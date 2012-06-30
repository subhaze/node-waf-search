<?php
    $context = stream_context_create(array('http' => array('header'=>'Connection: close')));
    $repos = file_get_contents("http://registry.npmjs.org/-/scripts?scripts=install,preinstall,postinstall&match=\bnode-waf\b",false,$context);
    $repos = json_decode($repos);
?>

<html>
    <title>node.js 0.8.0 outdated packages</title>
    <style>
        .package{
            background: #2f2f2f;
            border-radius: 5px;
            color: #dfdfdf;
            display: inline-block;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-weight: 200;
            letter-spacing: 1px;
            margin: 10px 10px;
            padding: 5px;
            width: 200px;
        }
        input{
            background: #eaeaea;
            border: 1px solid #111;
            border-radius: 5px;
            margin: 10px;
            padding: 5px 10px;
            width: 200px;
        }
        .hide{display: none;}
        .show{display: inline-block}
    </style>
<body>
    <input type="text" id="packageName" placeholder="enter package name" />
    <div id="results">
        <?php
            foreach($repos as $key => $value){
                echo '<span class="package">' . $key . '</span>';
            }
        ?>
    </div>
        <script src="https://ajax.googleapis.com/ajax/libs/mootools/1.4.5/mootools-yui-compressed.js"></script>
        <script>
            var moduleName = $('packageName')
            ,   modules = $$('.package')
            ,   results = $('results');
            
            moduleName.addEvent('keyup', function(){
                if(this.get('value') === ''){
                    modules.removeClass('hide');
                    return;
                }
                modules.each(function(item){
                    (item.innerHTML.indexOf(moduleName.value) > -1)
                    ? item.removeClass('hide')
                    : item.addClass('hide');
                });
                
            });
        </script>
</body>
</html>

