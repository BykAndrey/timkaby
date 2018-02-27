<?php $__env->startSection('content'); ?>

    <h1>Панель администратора</h1>

    <div>
        <h2>Основные данные</h2>
        <form action="/admin" method='post'>
            <?php echo e(csrf_field()); ?>

            <table class="create">


                <tr>
                    <td>
                        Title
                    </td>
                    <td>
                        <input type="text" name="title" value="<?php echo e($main_title); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        seo_description
                    </td>
                    <td>
                        <textarea name="seo_description" id="" cols="30" rows="10"><?php echo e($seo_description); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="">Текст на главной странице</label>
                    </td>
                    <td>
                        <textarea class="text_redactor" name="text_main_page" id="" cols="30" rows="10">
                            <?php echo e($text_main_page); ?>

                        </textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Сохранить">
                    </td>
                    <td>

                    </td>
                </tr>

            </table>

        </form>
    </div>


    <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>