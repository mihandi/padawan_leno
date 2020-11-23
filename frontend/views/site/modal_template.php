

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<?php if(isset($model) && !$model->errors):?>
    <div align="center" style='color: #64a933;'>Добро пожаловать</div>
    <script>
        window.location.reload()
    </script>
<?php else: ?>
    <div class="modal fade" id="LoginModal"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" onclick="getLoginForm()">
                        <h4 class="modal-title" id="Login">Вхiд</h4>
                    </button>
                    <button type="button" class="close" onclick="getSignUpForm()">
                        <h4 class="modal-title" id="Signup">Реєстрація</h4>
                    </button>

                </div>
                <?php require_once('login.php');?>
            </div>
        </div>
    </div>
<?php endif;?>

<script>
   function getSignUpForm() {
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
   }
   function getLoginForm() {
       $.ajax({
           type: $(this).attr('method'),
           url: '/site/login',
           data: new FormData(this),
           contentType: false,
           cache: false,
           processData: false,
           success: function(html){
               $('#form').html(html);
           }
       });
   }

</script>