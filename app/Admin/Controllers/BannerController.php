<?php

namespace App\Admin\Controllers;

use App\Models\Banner;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Controllers\Constant;

class BannerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Banner';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Banner());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('link', __('Link'));
        $grid->position('Position')->display(function($position) {
            return Constant::BANNER_POSITION[$position];
        });
        $grid->column('order', __('Order'));
        $grid->column('img', __('Img'))->image();
        $grid->show('Show')->display(function($show) {
            if (isset($show)){
                return Constant::SHOW_STATUS[$show];
            }
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Banner::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('link', __('Link'));
        $show->field('position', __('Position'));
        $show->field('order', __('Order'));
        $show->field('show', __('Show'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('img', __('Img'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Banner());

        $form->text('name', __('Name'));
        $form->url('link', __('Link'));
        $form->select('position', __('Position'))->options(Constant::BANNER_POSITION)->setWidth(1, 2);
        $form->number('order', __('Order'));
        $form->image('img', __('Img'));
        $form->switch("show")->states(Constant::SWITCH_STATE);

        return $form;
    }
}
