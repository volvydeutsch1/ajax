<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Create An Account</h2>
            <p>Please fill this form to register with us</p>
            <form action="<?php echo URLROOT; ?>/users/registerAjax" method="post" id="form">
                <div class="form-group">
                    <label>Age:<sup>*</label>
                    <input type="text" name="age" class="form-control form-control-lg" value="<?php echo $data['age']; ?>">
                    <span class="invalid-feedback"><?php echo $data['age_err']; ?></span>
                </div>
                <div class="form-group">
                    <label>Name:<sup>*</label>
                    <input type="text" name="name" class="form-control form-control-lg " value="<?php echo $data['name']; ?>">
                    <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                </div>
                <div class="form-group">
                    <label>Email Address:<sup>*</sup></label>
                    <input type="text" name="email" class="form-control form-control-lg" value="<?php echo $data['email']; ?>">
                    <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                </div>
                <div class="form-group">
                    <label>Username:<sup>*</label>
                    <input type="text" name="username" class="form-control form-control-lg" value="<?php echo $data['username']; ?>">
                    <span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
                </div>
                <div class="form-group">
                    <label>Password:<sup>*</sup></label>
                    <input type="password" name="password" class="form-control form-control-lg" value="<?php echo $data['password']; ?>">
                    <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                </div>
                <div class="form-group">
                    <label>Confirm Password:<sup>*</sup></label>
                    <input type="password" name="confirm_password" class="form-control form-control-lg" value="<?php echo $data['confirm_password']; ?>">
                    <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
                </div>

                <div class="form-row">
                    <div class="col">
                        <input type="submit" class="btn btn-success btn-block" value="Register" id="submit">
                    </div>
                    <div class="col">
                        <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-light btn-block">Have an account? Login</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('form').addEventListener('submit', validate);

        function validate(e){
            e.preventDefault();
            let age = document.getElementsByName('age').value;
            let name = document.getElementsByName('name').value;
            let email = document.getElementsByName('email').value;
            let username = document.getElementsByName('username').value;
            let password = document.getElementsByName('password').value;
            let confirm_password = document.getElementsByName('confirm_password').value;

            let params = 'age='+age+'&name='+name+'&email='+email+'&username='+username+'&password='+password+'&confirm_password='+confirm_password;

            let xhr = new XMLHttpRequest();
            xhr.open('POST', "<?php echo URLROOT . '/users/registerAjax'; ?>", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                console.log(this.responseText);

            }

            xhr.send(params);
        }
    </script>
    <?php require APPROOT . '/views/inc/footer.php'; ?>
