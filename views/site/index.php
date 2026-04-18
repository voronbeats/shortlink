<?php
use yii\helpers\Url;
?>

<div class="container mt-5">
    <h3>Сервис коротких ссылок</h3>

    <input id="url" class="form-control" placeholder="Введите URL">
    <button id="submitBtn" class="btn btn-primary mt-2">OK</button>

    <div id="result" class="mt-3"></div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$('#submitBtn').click(function () {
    $.ajax({
        url: '/site/create',
        method: 'POST',
        data: {url: $('#url').val()},
        success: function (data) {
            if (data.error) {
                alert(data.error);
            } else {
                $('#result').html(`
                    <p><a href="${data.short}" target="_blank">${data.short}</a></p>
                    <img src="${data.qr}" width="200">
                `);
            }
        }
    });
});
</script>