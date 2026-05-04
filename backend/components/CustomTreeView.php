<?php

namespace backend\components;

use kartik\base\Lib;
use kartik\tree\TreeView;
use kartik\tree\models\Tree;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class CustomTreeView extends TreeView
{
    public $mainTemplate = '<div class="col-12">{wrapper}</div>
<div class="modal fade" id="kv-node-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gestione nodo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">{detail}</div>
        </div>
    </div>
</div>';
    public $wrapperTemplate = "{header}\n{tree}{footer}";

    public function renderHeader()
    {
        $heading = ArrayHelper::getValue($this->headingOptions, 'label', 'Nodi');
        $search  = $this->renderSearch();

        $thead = Html::tag(
            'div',
            Html::tag('div', 'Nome',    ['class' => 'kv-col-name']) .
                Html::tag('div', 'Livello', ['class' => 'kv-col-level']) .
                Html::tag('div', 'Slug',    ['class' => 'kv-col-slug']) .
                Html::tag('div', 'Stato',   ['class' => 'kv-col-status']) .
                Html::tag('div', 'Azioni',  ['class' => 'kv-col-actions']),
            ['class' => 'kv-grid-thead']
        );

        return Html::tag(
            'div',
            Html::tag(
                'div',
                Html::tag(
                    'div',
                    Html::tag('span', strtoupper($heading), [
                        'style' => 'font-size:11px;font-weight:600;color:#6c757d;letter-spacing:.5px;',
                    ]),
                    ['class' => 'col-sm-4 d-flex align-items-center']
                ) .
                    Html::tag('div', $search, ['class' => 'col-sm-8']),
                ['class' => 'row align-items-center']
            ) . $thead,
            ['style' => 'background:#f8f9fa;border-bottom:1px solid #dee2e6;padding:10px 14px 0;']
        );
    }

    public function renderFooter()
    {
        return Html::tag('div', $this->renderToolbar(), [
            'style' => 'background:#f8f9fa;border-top:1px solid #dee2e6;padding:8px 12px;',
        ]);
    }

    public function renderTree()
    {
        $structure = $this->_module->treeStructure + $this->_module->dataStructure;
        extract($structure);

        $nodeDepth = $currDepth = $counter = 0;
        $prevRoot  = null;
        $out = Html::beginTag('ul', ['class' => 'kv-tree']) . "\n";

        foreach ($this->_nodes as $node) {
            /**
             * @var Tree $node
             */
            if (!$this->isAdmin && !$node->isVisible() || !$this->showInactive && !$node->isActive()) {
                continue;
            }

            $nodeDepth    = $node->$depthAttribute;
            $nodeLeft     = $node->$leftAttribute;
            $nodeRight    = $node->$rightAttribute;
            $nodeKey      = $node->$keyAttribute;
            $nodeName     = $node->$nameAttribute;
            $nodeIcon     = $node->$iconAttribute;
            $nodeIconType = $node->$iconTypeAttribute;
            $nodeRoot     = isset($treeAttribute) ? $node->$treeAttribute : null;

            // Reset quando cambia root
            if ($prevRoot !== null && $prevRoot !== $nodeRoot) {
                $out .= Lib::str_repeat("</li>\n</ul>", $currDepth) . "</li>\n";
                $currDepth = 0;
                $counter   = 0;
            }
            $prevRoot = $nodeRoot;

            $isChild = ($nodeRight == $nodeLeft + 1);
            $indicators = '';

            if (isset($this->nodeLabel)) {
                $label = $this->nodeLabel;
                $nodeName = is_callable($label) ? $label($node) : (is_array($label) ? ArrayHelper::getValue($label, $nodeKey, $nodeName) : $nodeName);
            }

            // Identica logica originale Kartik
            if ($nodeDepth == $currDepth) {
                if ($counter > 0) {
                    $out .= "</li>\n";
                }
            } elseif ($nodeDepth > $currDepth) {
                $out .= Html::beginTag('ul') . "\n";
                $currDepth = $currDepth + ($nodeDepth - $currDepth);
            } elseif ($nodeDepth < $currDepth) {
                $out .= Lib::str_repeat("</li>\n</ul>", $currDepth - $nodeDepth) . "</li>\n";
                $currDepth = $currDepth - ($currDepth - $nodeDepth);
            }

            if (Lib::trim($indicators) == null) {
                $indicators = '&nbsp;';
            }

            $nodeOptions = [
                'data-key'           => $nodeKey,
                'data-lft'           => $nodeLeft,
                'data-rgt'           => $nodeRight,
                'data-lvl'           => $nodeDepth,
                'data-disabled'      => static::parseBool($node->isDisabled()),
                'data-readonly'      => static::parseBool($node->isReadonly()),
                'data-movable-u'     => static::parseBool($node->isMovable('u')),
                'data-movable-d'     => static::parseBool($node->isMovable('d')),
                'data-movable-l'     => static::parseBool($node->isMovable('l')),
                'data-movable-r'     => static::parseBool($node->isMovable('r')),
                'data-removable'     => static::parseBool($node->isRemovable()),
                'data-removable-all' => static::parseBool($node->isRemovableAll()),
                'data-child-allowed' => static::parseBool($node->isChildAllowed()),
            ];

            $css = [];
            if (!$isChild) {
                $css[] = 'kv-parent ';
            }
            if (!$node->isVisible() && $this->isAdmin) {
                $css[] = 'kv-invisible';
            }
            if ($this->showCheckbox && $node->isSelected()) {
                $css[] = 'kv-selected ';
            }
            if ($node->isCollapsed()) {
                $css[] = 'kv-collapsed ';
            }
            if ($node->isDisabled()) {
                $css[] = 'kv-disabled ';
            }
            if (!$node->isActive()) {
                $css[] = 'kv-inactive ';
            }
            $indicators .= $this->renderToggleIconContainer() . "\n";
            $indicators .= $this->showCheckbox ? $this->renderCheckboxIconContainer() . "\n" : '';
            if (!empty($css)) {
                Html::addCssClass($nodeOptions, $css);
            }

            // ── Colonne extra ──
            $actions =
                Html::button('<i class="far fa-edit"></i>', [
                    'class'     => 'btn btn-info mb-md-0 mb-2 kv-btn-edit',
                    'title'     => 'Modifica',
                    'data-pjax' => '0',
                ]) . ' ' .
                ($isChild ? Html::button('<i class="far fa-trash-alt"></i>', [
                    'class'     => 'btn btn-danger mb-md-0 mb-2 kv-btn-delete',
                    'title'     => 'Elimina',
                    'data-pjax' => '0',
                ]) : '');

            // Struttura identica all'originale Kartik + colonne extra
            $out .= Html::beginTag('li', $nodeOptions) . "\n" .
                Html::beginTag('div', ['tabindex' => -1, 'class' => 'kv-tree-list']) . "\n" .
                Html::beginTag('div', ['class' => 'kv-node-indicators']) . "\n" .
                $indicators . "\n" .
                '</div>' . "\n" .
                Html::beginTag('div', ['tabindex' => -1, 'class' => 'kv-node-detail']) . "\n" .
                $this->renderNodeIcon($nodeIcon, $nodeIconType, $isChild) . "\n" .
                Html::tag('span', $nodeName, ['class' => 'kv-node-label']) . "\n" .
                '</div>' . "\n" .
                // Colonne extra visive
                Html::tag('div', (string)($nodeDepth - 1), ['class' => 'kv-col-level-val']) .
                Html::tag('div', $node->slug ?? '-', ['class' => 'kv-col-slug-val']) .
                Html::tag(
                    'div',
                    $node->active
                        ? '<span class="badge bg-success">Attivo</span>'
                        : '<span class="badge bg-secondary">Inattivo</span>',
                    ['class' => 'kv-col-status-val']
                ) .
                Html::tag('div', $actions, ['class' => 'kv-col-actions-val']) .
                '</div>' . "\n";

            ++$counter;
        }

        // Identica chiusura originale Kartik
        $out .= Lib::str_repeat("</li>\n</ul>", $nodeDepth) . "</li>\n";
        $out .= "</ul>\n";

        if (!$this->hideTopRoot && !$this->topRootAsHeading) {
            $out = $this->renderRoot() . $out;
        }

        return Html::tag('div', $out, $this->treeOptions);
    }
}
