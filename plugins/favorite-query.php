<?php

/**
 * Favorite Query using localstorage or filesystem
 * @author Andrea Mariani, fasys.it
 */
class AdminerFavoriteQuery
{
    const STORAGE_NAME = 'adminer_favorite_query';

    public function head(){
        $persistent = class_exists("AdminerFavoriteQueryFileSystem");

        $sql = filter_input(INPUT_GET, 'sql');
        if (!isset($sql)) {
            return;
        }

        $remove_favorite = filter_input(INPUT_GET, 'remove_favorite');
        $query = trim(filter_input(INPUT_POST, 'query'));

        if(filter_input(INPUT_POST, 'add_favorite') && $query){
            $_POST['query'] = trim((string)$_POST['query']);

            $now = new DateTime();
            $datetime = $now->format("y-m-d H:i:s");
            $query_hash = sha1($_POST['query']);

            if($persistent){
                //save in a file on the server
                $storage = file_get_contents(self::STORAGE_NAME);
                $storage = json_decode((string)$storage, true);

                $storage[$query_hash] = [];
                $storage[$query_hash]['datetime'] = $datetime;
                $storage[$query_hash]['query'] = rawurlencode($query);

                file_put_contents(self::STORAGE_NAME, json_encode($storage));
            }
            else{
                //save in localstorage on the browser
                $query = str_replace("`", "\`", $_POST['query']);
            ?>
                <script<?php echo nonce() ?>>
                const now = new Date();
                let query = `<?php echo $query ?>`;
                let query_hash = '<?php echo $query_hash ?>';
                let storage = JSON.parse(localStorage.getItem('<?php echo self::STORAGE_NAME ?>')) || {};
                storage[query_hash] = {};
                storage[query_hash]['datetime'] = '<?php echo $datetime ?>';
                storage[query_hash]['query'] = encodeURIComponent(query);
                localStorage.setItem('<?php echo self::STORAGE_NAME ?>', JSON.stringify(storage));
                </script>
            <?php
            }
        }
        elseif($remove_favorite){
            if($persistent) {
                //filesystem
                $storage = file_get_contents(self::STORAGE_NAME);
                $storage = json_decode((string)$storage, true);
                unset($storage[$remove_favorite]);
                file_put_contents(self::STORAGE_NAME, json_encode((object)$storage));
            }
            else {
                //localstorage
            ?>
                <script<?php echo nonce() ?>>
                let storage = localStorage.getItem('<?php echo self::STORAGE_NAME ?>');
                storage = storage ? JSON.parse(storage) : {};
                if('<?php echo $remove_favorite ?>' in storage) {
                    delete storage['<?php echo $remove_favorite ?>'];
                }
                localStorage.setItem('<?php echo self::STORAGE_NAME ?>', JSON.stringify(storage));
                </script>
            <?php
            }
        }
        ?>

        <script<?php echo nonce();?> type="text/javascript">
            function domReady(fn) {
                document.addEventListener("DOMContentLoaded", fn);
                if (document.readyState === "interactive" || document.readyState === "complete" ) {
                    fn();
                }
            }

            domReady(() => {
                const formp1 = document.querySelectorAll('#form p')[1];
                formp1.insertAdjacentHTML('beforeend', '<label style="margin-left:3px;"><input type="checkbox" name="add_favorite" value="1" /><?php echo h('Add to Favorites') ?></label>');

                let favorite_queries = "";
                let storage;

                <?php
                if($persistent){
                    $storage = file_get_contents(self::STORAGE_NAME);
                    echo "storage = `{$storage}`;";
                }
                else{ ?>
                    storage = localStorage.getItem('<?php echo self::STORAGE_NAME ?>');
                <?php } ?>

                console.log(storage);

                if(!storage){
                    storage = "{}";
                }
                console.log(storage);

                //order by descending
                storage = JSON.parse(storage);
                console.log(storage);
                const reversedStorage = Object.keys(storage)
                    .reverse()
                    .reduce((acc, key) => {
                        acc[key] = storage[key];
                        return acc;
                    }, {});

                for (let query_hash in reversedStorage) {
                    favorite_queries += `
                    <div>
                        <a title="<?php echo h('Use Favorite') ?>" href="?username=<?php echo $_GET['username'] ?>&db=<?php echo $_GET['db'] ?>&sql=${storage[query_hash]['query']}"><img style="padding:1px; width: 15px; " src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1NzYgNTEyIj48IS0tISBGb250IEF3ZXNvbWUgUHJvIDYuNS4xIGJ5IEBmb250YXdlc29tZSAtIGh0dHBzOi8vZm9udGF3ZXNvbWUuY29tIExpY2Vuc2UgLSBodHRwczovL2ZvbnRhd2Vzb21lLmNvbS9saWNlbnNlIChDb21tZXJjaWFsIExpY2Vuc2UpIENvcHlyaWdodCAyMDIzIEZvbnRpY29ucywgSW5jLiAtLT48cGF0aCBkPSJNMjI2LjUgMTY4LjhMMjg3LjkgNDIuM2w2MS40IDEyNi41YzQuNiA5LjUgMTMuNiAxNi4xIDI0LjEgMTcuN2wxMzcuNCAyMC4zLTk5LjggOTguOGMtNy40IDcuMy0xMC44IDE3LjgtOSAyOC4xbDIzLjUgMTM5LjVMMzAzIDQwNy43Yy05LjQtNS0yMC43LTUtMzAuMiAwTDE1MC4yIDQ3My4ybDIzLjUtMTM5LjVjMS43LTEwLjMtMS42LTIwLjctOS0yOC4xTDY1IDIwNi44bDEzNy40LTIwLjNjMTAuNS0xLjUgMTkuNS04LjIgMjQuMS0xNy43ek00MjQuOSA1MDkuMWM4LjEgNC4zIDE3LjkgMy43IDI1LjMtMS43czExLjItMTQuNSA5LjctMjMuNUw0MzMuNiAzMjguNCA1NDQuOCAyMTguMmM2LjUtNi40IDguNy0xNS45IDUuOS0yNC41cy0xMC4zLTE0LjktMTkuMy0xNi4zTDM3OC4xIDE1NC44IDMwOS41IDEzLjVDMzA1LjUgNS4yIDI5Ny4xIDAgMjg3LjkgMHMtMTcuNiA1LjItMjEuNiAxMy41TDE5Ny43IDE1NC44IDQ0LjUgMTc3LjVjLTkgMS4zLTE2LjUgNy42LTE5LjMgMTYuM3MtLjUgMTguMSA1LjkgMjQuNUwxNDIuMiAzMjguNCAxMTYgNDgzLjljLTEuNSA5IDIuMiAxOC4xIDkuNyAyMy41czE3LjMgNiAyNS4zIDEuN2wxMzctNzMuMiAxMzcgNzMuMnoiLz48L3N2Zz4=" /></a>
                        <a title="<?php echo h("Delete Favorite") ?>" class="remove_favorite" href="?username=<?php echo $_GET['username'] ?>&db=<?php echo $_GET['db'] ?>&sql=&remove_favorite=${query_hash}"><img style="padding:1px; width: 15px; " src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAHSSURBVHjapFM5bsJQEB2zSIDFJrHYpEtyAyoKJAp6CrqIkBPkNDlBAKXjBEgUpKOBCyQNijFiEZvZl8z7wsjESYpkpNFfPO/Nmz9j6Xg80n/M9fWi3W7fMOnd4XAo8qogAbvO5xKvL6lU6s0aL1kVMDjP5ye/36+Gw2FyOp3EQFqtVtTr9WixWHT5/JhOp6s2ghP4ORaLyaFQiGazGa3Xa0HgdrvJ6/WSpmk0Go0MjnvIZDLVM0Gr1brm/WskEkkA3O/3abvdQjq5XC6xgoiVka7rNB6PNT6ns9nsu+OkpODxeBLBYJAGgwHt9/uzQ8Vms6Hdbie+KYqC+ASTFrARBMx2HwgEaDKZiHqn0yktl0uxtzrMMAyKx+MCc+4Cs13hwQCC1GQy+W3Lms2mUIUygbEqEBLNun8z8zswVgUfLO0WD4Z6kekn8/l8okNM8GFVUMYDoVWQ6HA4bEAzoyzL1O12kbRsJajwhYZhiUajJEnShWSAQaqqKnU6HahEGysXg9RoNPJ8+cwZZLSKp47m8/k5Kxzg4XBocNxDLper2ka5Xq+LUeatilahJLN1mEJ+ZDHKJthGAKvVauJnYi9ysHIqQee1xOsLg3/+mf5inwIMAJMhb74NwG5wAAAAAElFTkSuQmCC" /></a>
                        <span class="time">${storage[query_hash]['datetime']}</span>
                        <code style="display: inline-block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:600px; vertical-align:middle;">`+ jush.highlight("sql", decodeURIComponent(storage[query_hash]['query'])) +`</code>
                    </div>`;
                }

                formp1.insertAdjacentHTML('afterend', `
                    <div>
                    <fieldset><legend><a href="#favorite-queries"><?php echo h('Favorites') ?></a></legend>
                    <div id="favorite-queries">${favorite_queries}</div>
                    </fieldset>
                    </div>`);

                qsl("a[href='#favorite-queries']").onclick = partial(toggle, "favorite-queries");

                document.querySelectorAll('.remove_favorite').forEach(link => {
                    link.addEventListener('click', function(event) {
                        const userConfirmed = confirm("<?php echo h("Are you sure you want to delete this favorite query?") ?>");
                        if (!userConfirmed) {
                            event.preventDefault();
                        }
                    });
                });
            });

        </script>
        <?php
    }
}
