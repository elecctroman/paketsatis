<?php ob_start(); ?>
<div class="text-center">
    <h2>Kurulum tamamlandı!</h2>
    <p>Yönetim paneline giriş yapmak için aşağıdaki bağlantıyı kullanabilirsiniz.</p>
    <a class="btn btn-success" href="/login">Yönetim Paneli</a>
    <hr>
    <p>Cron Ayarı:</p>
    <code>* * * * * /usr/local/bin/php /home/CPANEL_USER/public_html/cli/schedule.php >> /dev/null 2>&1</code>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/layout.php'; ?>
