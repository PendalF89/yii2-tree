yii2-tree
=========

Tree widget for Yii2 models

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist pendalf89/yii2-tree "*"
```

or add

```
"pendalf89/yii2-tree": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by :
```
<?= TreeWidget::widget([
    'models' => $models,
    'value' => function($model) {
            return $model->title;
        }
]) ?>
```
