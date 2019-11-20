<?php

namespace Xylophone\CRUD\Tests\Unit\CrudPanel;

use Xylophone\CRUD\app\Library\CrudPanel\CrudPanel;
use Xylophone\CRUD\Tests\BaseTest;
use Xylophone\CRUD\Tests\Unit\Models\TestModel;

abstract class BaseCrudPanelTest extends BaseTest
{
    /**
     * @var CrudPanel
     */
    protected $crudPanel;

    protected $model;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->crudPanel = new CrudPanel();
        $this->crudPanel->setModel(TestModel::class);
        $this->model = $this->crudPanel->getModel();
    }
}
