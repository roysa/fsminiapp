<?php
$this->layout = 'admin';
$app = FSMiniApp::app();

$ul = $app->auth->getList();

if (isset($_POST['login']) && isset($_POST['password'])) {
    if (isset($_POST['delete'])) {
        foreach ($_POST['delete'] as $login => $_) {
            $app->auth->delete($login);
        }
        $app->redirect();
    }
    foreach ($_POST['login'] as $i => $login) {
        $password = $_POST['password'][$i];
        if ($password) {
            if (in_array($login, $ul)) {
                $app->auth->passwd($login, $password);
            } else {
                $app->auth->addUser($login, $password);
            }
        }
    }
    $app->redirect();
}

?>
<form action="<?php echo $app->createUrl('users'); ?>" method="post">
    <table>
        <thead>
            <tr>
                <td>Login</td>
                <td>Password</td>
                <td></td>
            </tr>
        </thead>
    <?php foreach ($ul as $login) : ?>
        <tr>
        <input type="hidden" name="login[]" value="<?php echo $app->encode($login); ?>">
            <td><?php echo $app->encode($login); ?></td>
            <td><input type="text" name="password[]" value=""></td>
            <td><input type="submit" name="delete[<?php echo $app->encode($login); ?>]" value="-" title="Delete"></td>
        </tr>
    <?php endforeach; ?>
        <tr>
            <td><input type="text" name="login[]" value="" placeholder="new user login"></td>
            <td><input type="text" name="password[]" value=""></td>
            <td></td>
        </tr>
        <tr class="buttons">
            <td colspan="3"><input type="submit" value="Save"></td>
        </tr>
    </table>
</form>