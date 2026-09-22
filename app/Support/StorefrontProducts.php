<?php

namespace App\Support;

class StorefrontProducts
{
    public static function all(): array
    {
        return [
            ['id' => 1, 'name' => 'Вулик ППУ 10-рамковий', 'price' => '4 200', 'category' => 'hives', 'tag' => 'Хіт', 'type' => 'hive-blue'],
            ['id' => 2, 'name' => 'Корпус ППУ 10-рамковий', 'price' => '1 250', 'category' => 'bodies', 'tag' => '-10%', 'type' => 'box-yellow'],
            ['id' => 3, 'name' => 'Кришка ППУ з вентиляцією', 'price' => '650', 'category' => 'roofs', 'tag' => '', 'type' => 'lid-gray'],
            ['id' => 4, 'name' => 'Рамка дерев’яна 300 мм', 'price' => '350', 'category' => 'frames', 'tag' => '', 'type' => 'frame-wood'],
            ['id' => 5, 'name' => 'Дно ППУ гігієнічне', 'price' => '790', 'category' => 'bottoms', 'tag' => 'Новинка', 'type' => 'bottom-gray'],
            ['id' => 6, 'name' => 'Набір пасічних інструментів', 'price' => '980', 'category' => 'tools', 'tag' => '', 'type' => 'tools-set'],
            ['id' => 7, 'name' => 'Вулик ППУ 12-рамковий', 'price' => '4 850', 'category' => 'hives', 'tag' => 'Хіт', 'type' => 'hive-yellow'],
            ['id' => 8, 'name' => 'Магазинна надставка ППУ', 'price' => '1 100', 'category' => 'bodies', 'tag' => '', 'type' => 'box-blue'],
            ['id' => 9, 'name' => 'Вулик ППУ 8-рамковий', 'price' => '3 750', 'category' => 'hives', 'tag' => '-8%', 'type' => 'hive-blue'],
            ['id' => 10, 'name' => 'Корпус ППУ 12-рамковий', 'price' => '1 390', 'category' => 'bodies', 'tag' => '', 'type' => 'box-yellow'],
            ['id' => 11, 'name' => 'Дно ППУ з літковою перегородкою', 'price' => '860', 'category' => 'bottoms', 'tag' => '', 'type' => 'bottom-gray'],
            ['id' => 12, 'name' => 'Дах ППУ високий', 'price' => '720', 'category' => 'roofs', 'tag' => 'Новинка', 'type' => 'lid-gray'],
            ['id' => 13, 'name' => 'Рамка дерев’яна 230 мм', 'price' => '290', 'category' => 'frames', 'tag' => '', 'type' => 'frame-wood'],
            ['id' => 14, 'name' => 'Рамка дерев’яна 145 мм', 'price' => '240', 'category' => 'frames', 'tag' => '', 'type' => 'frame-wood'],
            ['id' => 15, 'name' => 'Стамеска пасічна нержавіюча', 'price' => '210', 'category' => 'tools', 'tag' => '', 'type' => 'tools-set'],
            ['id' => 16, 'name' => 'Димар пасічний із захистом', 'price' => '540', 'category' => 'tools', 'tag' => '-12%', 'type' => 'tools-set'],
            ['id' => 17, 'name' => 'Годівниця стельова 1,5 л', 'price' => '185', 'category' => 'tools', 'tag' => '', 'type' => 'box-blue'],
        ];
    }
}
