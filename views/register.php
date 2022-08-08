<div class="column is-6 is-offset-3">
    <?php
        if (app()->session->has('registered', true)) {
            echo '<p class="has-text-success has-text-centered">'. app()->session->get('registered', true) .'</p>';
        }
    ?>
    <form name="register" method="post">
        <div class="field">
            <label for="name" class="label">Name</label>
            <div class="control">
                <input id="name" class="input" type="text" placeholder="Person Name" value="<?= old('name') ?>" name="name" />
            </div>
            <?php
                if (app()->session->has('name', true)) {
                    echo '<p class="help is-danger">'. app()->session->get('name', true)[0] .'</p>';
                }
            ?>
        </div>

        <div class="field">
            <label for="email" class="label">Email</label>
            <div class="control">
                <input id="email" class="input" type="email" placeholder="email@example.com" value="<?= old('email') ?>" name="email">
            </div>
            <?php
                if (app()->session->has('email', true)) {
                    echo '<p class="help is-danger">'. app()->session->get('email', true)[0] .'</p>';
                }
            ?>
        </div>

        <div class="field">
            <label for="password" class="label">Password</label>
            <div class="control">
                <input id="password" class="input" type="password" name="password">
            </div>
            <?php
                if (app()->session->has('password', true)) {
                    echo '<p class="help is-danger">'. app()->session->get('password', true)[0] .'</p>';
                }
            ?>
        </div>

        <div class="field">
            <label for="confirm-password" class="label">Confirm password</label>
            <div class="control">
                <input id="confirm-password" class="input" type="password" name="password_confirmation">
            </div>
        </div>

        <button class="button is-link">Submit</button>
    </form>
</div>
