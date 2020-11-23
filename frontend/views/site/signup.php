<?php
function err($errors)
{
    foreach ($errors as $error){
        echo "<div class=\"help-block help-block-error \" style='color: #a94442'> $error </div>";
    }
}
?>

<div class="modal-body" id="form">
    <form method="post" action="/site/signup" id="form_to_signup">
        <div class="form-group">
            <label  class="form-control-label">Логин:</label>
            <input type="text" class="form-control" name="SignupForm[login]" id="login" value="<?= $model['login']?>">
            <?php if(isset($model->errors['login'])):?>
                <?php err($model->errors['login']); ?>
            <?php endif;?>
        </div>
        <div class="form-group">
            <label  class="form-control-label">Email:</label>
            <input type="email" class="form-control" name="SignupForm[email]" id="email" value="<?= $model['email']?>">
            <?php if(isset($model->errors['email'])):?>
                <?php err($model->errors['email']); ?>
            <?php endif;?>
        </div>
        <div class="form-group">
            <label  class="form-control-label">Пароль:</label>
            <input type="password" class="form-control" name="SignupForm[password]" id="password">
            <?php if(isset($model->errors['password'])):?>
                <?php err($model->errors['password']); ?>
            <?php endif;?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
            <button type="submit" id="submit" class="btn au-btn-primary">Зареєструватися</button>
        </div>
    </form>
</div>

<script>
    $( document ).ready(function() {
        $( "#form_to_signup" ).submit(function( event ) {
            event.preventDefault();
            $.ajax({
                type: $(this).attr('method'),
                url: '/site/signup',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(html){
                    $('#form').html(html);
                }
            });
        });
    });
</script>