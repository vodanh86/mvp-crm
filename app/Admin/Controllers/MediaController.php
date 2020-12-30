<?php

namespace App\Admin\Controllers;

use App\Models\Media;
use App\Models\Post;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MediaController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Media';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Media());

        $grid->column('id', __('Id'));
        $grid->column('link', __('Link'))->image();
        $grid->column('title', __('Title'));
        $grid->post_id('Post')->display(function($postId) {
            $post = Post::find($postId);
            if($post){
                return $post->title;
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
        $show = new Show(Media::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('link', __('Link'));
        $show->field('title', __('Title'));
        $show->field('post_id', __('Post id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Media());

        $form->file('link', __('Link'));
        $form->text('title', __('Title'));
        $form->select('post_id', trans('Post Id'))->options(Post::where('category_id', 5)->get()->pluck('title','id'))->setWidth(4, 2);


        return $form;
    }
}
