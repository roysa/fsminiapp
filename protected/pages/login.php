<?php
$app = FSMiniApp::app();
if ($app->auth->auth()) {
    $this->redirect('/');
}
$login = ''; 
?>
<?php if (isset($_POST['login']) && isset($_POST['password']) && $_POST['login'] && $_POST['password']) : ?>
<?php
    $login = strip_tags($_POST['login']);
    if ($res = $app->auth->auth($login, $_POST['password'])) {
        $app->redirect();
    }
?>    
<?php endif; ?>
<form action="/login" method="post">
    <h3>Login</h3>
    <input type="text" name="login" value="<?php echo htmlspecialchars($login); ?>" placeholder="login"><br/>
    <input type="password" name="password" value="" placeholder="password" ><br/>
    <input type="submit" value="Login">
</form>