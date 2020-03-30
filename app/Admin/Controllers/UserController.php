<?php

namespace App\Admin\Controllers;

use App\Models\Users;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Hash;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Users());
        //搜索
        $grid->quickSearch('name');
        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'))->editable();
        $grid->column('email', __('Email'));
        $grid->column('email_verified_at', __('Email verified at'));
//        $grid->column('password', __('Password'));
//        $grid->column('remember_token', __('Remember token'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('image', __('Image'));
        //搜索
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            // 设置created_at字段的范围查询
            $filter->like('name', 'name');
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
        $show = new Show(Users::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('password', __('Password'));
        $show->field('remember_token', __('Remember token'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
//        $show->field('image', __('Image'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Users());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->password('password', __('Password'));
//        $form->text('remember_token', __('Remember token'));
        $form->image('image', __('Image'))->default('jREMRoIl6le02NZV3aOv1X8wZPD0vMz3uDk99lNT.gif');
        //上传大文件
//        $form->largefile('test', 'test');
//        $form->cropper('content','label');
//        $form->table('extra', function ($table) {
//            $table->text('key');
//            $table->text('value');
//            $table->text('desc');
//        });



        $form->saving(function (Form $form) {

            $form->password=Hash::make($form->password);
        });



        return $form;
    }
}
