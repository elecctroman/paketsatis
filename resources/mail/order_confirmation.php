<p>Merhaba <?= htmlspecialchars($name ?? 'Müşteri') ?>,</p>
<p>Siparişiniz alındı. Referans numaranız: <strong><?= htmlspecialchars($orderRef ?? '') ?></strong></p>
<p>Teşekkürler,<br>PaketSatis Ekibi</p>
