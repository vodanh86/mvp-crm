<?php

namespace App\Admin\Controllers;

use App\Models\Post;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PostController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Post';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Post());

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->category_id('Category id')->display(function($categoryId) {
            if (isset($categoryId)){
                return Constant::POST_CATEGORY[$categoryId];
            }
        });
        $grid->column('img', __('Img'))->image();
        $grid->column('author', __('Author'));
        $grid->column('address', __('Address'));
        $grid->column('happend_at', __('Happend at'));
        $grid->type('Type')->display(function($type) {
            if (isset($type)){
                return Constant::POST_TYPE[$type];
            }
        });
        $grid->column('view', __('View'));
        $grid->show('Show')->display(function($show) {
            if (isset($show)){
                return Constant::SHOW_STATUS[$show];
            }
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->quickSearch('title');
        $grid->filter(function($filter){

            // Remove the default id filter
            $filter->disableIdFilter();
        
            // Add a column filter
            $filter->like('title', 'title');
            $filter->equal('type')->select(Constant::POST_TYPE);
            $filter->equal('category_id')->select(Constant::POST_CATEGORY);
        });

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
        $show = new Show(Post::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('content', __('Content'));
        $show->field('view', __('View'));
        $show->field('show', __('Show'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('user_id', __('User id'));
        $show->field('category_id', __('Category id'));
        $show->field('img', __('Img'));
        $show->field('author', __('Author'));
        $show->field('address', __('Address'));
        $show->field('happend_at', __('Happend at'));
        $show->field('type', __('Type'));
        $show->field('Position')->latlong('lat_column', 'long_column', $height = 400, $zoom = 16);

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Post());

        $form->text('title', __('Title'));
        $form->ckeditor('content');
        $form->select('category_id', __('Category id'))->options(Constant::POST_CATEGORY)->setWidth(2, 2);
        $form->cropper('img', __('Img'))->cRatio(755, 524);
        $form->text('author', __('Author'));
        $form->text('address', __('Address'));
        $form->datetime('happend_at', __('Happend at'))->default(date('Y-m-d H:i:s'));
        $form->select('type', __('Type'))->options(Constant::POST_TYPE)->setWidth(2, 2);
        
        $form->switch("show")->states(Constant::SWITCH_STATE);
        // Set default position
        $form->latlong('latitude', 'longitude', 'Position')->default(['lat' => 10, 'lng' => 106]);

        return $form;
    }
}
