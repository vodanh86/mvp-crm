<?php

namespace App\Admin\Controllers;

use App\Models\Page;
use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\User;
use Encore\Admin\Layout\Content;
use App\Admin\Controllers\Constant;
use Encore\Admin\Facades\Admin;

class PageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Page';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Page());

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'))->filter('like');
        $grid->column('view', __('View'));
        $grid->column('img', __('Img'))->image();;
        $grid->show('Show')->display(function($show) {
            return Constant::SHOW_STATUS[$show];
        });
        $grid->status('Status')->display(function($status) {
            return Constant::PAGE_STATUS[$status];
        });
        $grid->user_id('Author')->display(function($userId) {
            $user = User::find($userId);
            if ($user){
                return $user->name;
            }
        });
        $grid->category_id('Category')->display(function($categoryId) {
            $category = Category::find($categoryId);
            if($category){
                return $category->title;
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
            $categories = Category::get();
            $select = array();
            foreach($categories as $category){
                $select[$category->id] = $category->title;
            }
            $filter->equal('status')->select(Constant::PAGE_STATUS);
            $filter->equal('category_id')->select($select);
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
        $show = new Show(Page::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('description', __('Description'));
        $show->field('content', __('Content'));
        $show->field('img', __('Img'));
        $show->field('view', __('View'));
        $show->field('show', __('Show'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('status', __('Status'));
        $show->field('user_id', __('User id'));
        $show->field('category_id', __('Category id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Page());

        $form->text('title', __('Title'));
        $form->ckeditor('description');
        $form->ckeditor('content');
        $form->image('img', __('Img'));
        $form->number('view', __('View'));
        $form->select('show', __('Show'))->options(Constant::SHOW_STATUS)->setWidth(1, 2);
        if (!Admin::user()->isRole('Editor')){
            $form->select('status', __('Status'))->options(Constant::PAGE_STATUS)->setWidth(1, 2);
        }
        $form->hidden('user_id')->default(auth()->user()->id);
        $form->select('category_id', trans('category_id'))->options(Category::all()->pluck('title','id'))->setWidth(3, 2);

        return $form;
    }
}
