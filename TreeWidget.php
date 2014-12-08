<?php

namespace pendalf89\tree;

use yii\helpers\Html;

/**
 * Class TreeWidget
 *
 * Displays models in tree view.
 *
 * @author Zabolotskikh Boris <zabolotskich@bk.ru>
 * @package pendalf89\blog\widgets
 */
class TreeWidget extends \yii\base\Widget
{
    /**
     * @var string primary key
     */
    public $id = 'id';

    /**
     * @var string parent id
     */
    public $parent_id = 'parent_id';

    /**
     * @var array models
     */
    public $models = [];

    /**
     * @var string callback function for disply content of each item. Have $model argument.
     */
    public $value = '';

    /**
     * @var array container html options
     */
    public $containerOptions = [];

    /**
     * @var bool container options already set or not
     */
    private $containerOptionsIsSet = false;

    /**
     * Run the widget
     * @return string tree
     */
    public function run()
    {
        return $this->buildTree($this->createTreeArray());
    }

    /**
     * Create tree array from models.
     * @return array tree array
     */
    private function createTreeArray()
    {
        $tree = [];

        foreach($this->models as $model) {
            $tree[] = [
                'id' => $model->{$this->id},
                'parent_id' => $model->{$this->parent_id},
                'model' => $model,
            ];
        }

        return $tree;
    }

    /**
     * Check node for child.
     * @param array $rows
     * @param int $id parent id
     * @return bool
     */
    private function hasChild($rows, $id)
    {
        foreach ($rows as $row) {
            if ($row['parent_id'] == $id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Create tree.
     * @param array $rows
     * @param int $parent_id
     * @return string tree
     */
    private function buildTree($rows, $parent_id = 0)
    {
        $containerAttributes = '';

        if (!$this->containerOptionsIsSet) {
            $containerAttributes = Html::renderTagAttributes($this->containerOptions);
            $this->containerOptionsIsSet = true;
        }

        $result = "<ul$containerAttributes>";

        foreach ($rows as $row) {
            if ($row['parent_id'] == $parent_id) {

                $value = call_user_func_array($this->value, ['model' => $row['model']]);
                $result .= "<li>$value";

                if ($this->hasChild($rows, $row['id'])) {
                    $result.= $this->buildTree($rows, $row['id']);
                }

                $result .= '</li>';
            }
        }

        $result .= '</ul>';

        return $result;
    }
}
