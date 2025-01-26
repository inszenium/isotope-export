:: Run easy-coding-standard (ecs) via this batch file inside your IDE e.g. PhpStorm (Windows only)
:: Install inside PhpStorm the  "Batch Script Support" plugin
cd..
cd..
cd..
cd..
cd..
cd..
php vendor\bin\ecs check vendor/roschis/contao-roschis-glynt/src --fix --config vendor/roschis/contao-roschis-glynt/tools/ecs/config.php
php vendor\bin\ecs check vendor/roschis/contao-roschis-glynt/contao --fix --config vendor/roschis/contao-roschis-glynt/tools/ecs/config.php
php vendor\bin\ecs check vendor/roschis/contao-roschis-glynt/config --fix --config vendor/roschis/contao-roschis-glynt/tools/ecs/config.php
php vendor\bin\ecs check vendor/roschis/contao-roschis-glynt/templates --fix --config vendor/roschis/contao-roschis-glynt/tools/ecs/config.php
php vendor\bin\ecs check vendor/roschis/contao-roschis-glynt/tests --fix --config vendor/roschis/contao-roschis-glynt/tools/ecs/config.php
