<h3>Зареєструвати аккаунт</h3>
<?= isset($data['errors'])? $data['errors'] : '';?>
<form id="form_register" action="login/register">
    <div class="form-group">
        <label for="usr">Логін:</label>
        <input type="text" name="user" required class="form-control" id="usr">
    </div>
    <div class="form-group">
        <label for="pwd">Пароль:</label>
        <input type="password" name="password" required class="form-control" id="pwd">
    </div>
    <div class="form-group">
        <label for="pwd">Підтвердження Паролю:</label>
        <input type="password" name="confirm_password" required class="form-control" id="pwd">
    </div>
    <button type="submit" class="btn btn-default">Зареєструватись</button>

</form>