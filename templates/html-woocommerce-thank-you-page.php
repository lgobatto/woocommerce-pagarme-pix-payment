<?php
defined( 'ABSPATH' ) || exit;

use chillerlan\QRCode\QRCode;

$order_id = wc_get_order_id_by_order_key($_GET['key']);
$order = wc_get_order( $order_id );

if( $order ){
    $paid = get_post_meta($order_id, '_wc_pagarme_pix_payment_paid', 'no') === 'yes' ? true : false;
}


?>
<style>
    .qrcode-copyed{
        box-shadow: 2px 2px 3px #e1e1e1;
        border-radius: 5px;
        width: 320px;
        border: 1px solid #dadada;
        margin: 0 auto;
        padding: 10px;
    }
    @-webkit-keyframes scaleAnimation {
    0% {
        opacity: 0;
        transform: scale(1.5);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
    }

    @keyframes scaleAnimation {
    0% {
        opacity: 0;
        transform: scale(1.5);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
    }
    @-webkit-keyframes drawCircle {
    0% {
        stroke-dashoffset: 151px;
    }
    100% {
        stroke-dashoffset: 0;
    }
    }
    @keyframes drawCircle {
    0% {
        stroke-dashoffset: 151px;
    }
    100% {
        stroke-dashoffset: 0;
    }
    }
    @-webkit-keyframes drawCheck {
    0% {
        stroke-dashoffset: 36px;
    }
    100% {
        stroke-dashoffset: 0;
    }
    }
    @keyframes drawCheck {
    0% {
        stroke-dashoffset: 36px;
    }
    100% {
        stroke-dashoffset: 0;
    }
    }
    @-webkit-keyframes fadeOut {
    0% {
        opacity: 1;
    }
    100% {
        opacity: 0;
    }
    }
    @keyframes fadeOut {
    0% {
        opacity: 1;
    }
    100% {
        opacity: 0;
    }
    }
    @-webkit-keyframes fadeIn {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
    }
    @keyframes fadeIn {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
    }
    #successAnimationCircle {
    stroke-dasharray: 151px 151px;
    stroke: #007bff;
    }

    #successAnimationCheck {
    stroke-dasharray: 36px 36px;
    stroke: #007bff;
    }

    #successAnimationResult {
    fill: #007bff;
    opacity: 0;
    }

    #successAnimation.animated {
    -webkit-animation: 1s ease-out 0s 1 both scaleAnimation;
            animation: 1s ease-out 0s 1 both scaleAnimation;
    }
    #successAnimation.animated #successAnimationCircle {
    -webkit-animation: 1s cubic-bezier(0.77, 0, 0.175, 1) 0s 1 both drawCircle, 0.3s linear 0.9s 1 both fadeOut;
            animation: 1s cubic-bezier(0.77, 0, 0.175, 1) 0s 1 both drawCircle, 0.3s linear 0.9s 1 both fadeOut;
    }
    #successAnimation.animated #successAnimationCheck {
    -webkit-animation: 1s cubic-bezier(0.77, 0, 0.175, 1) 0s 1 both drawCheck, 0.3s linear 0.9s 1 both fadeOut;
            animation: 1s cubic-bezier(0.77, 0, 0.175, 1) 0s 1 both drawCheck, 0.3s linear 0.9s 1 both fadeOut;
    }
    #successAnimation.animated #successAnimationResult {
    -webkit-animation: 0.3s linear 0.9s both fadeIn;
            animation: 0.3s linear 0.9s both fadeIn;
    }
</style>
<div class="text-center">
    <div id="successPixPaymentBox" style="display: <?php echo $paid ? 'block' : 'none'; ?>;">
        <h4>Obrigado pelo pagamento!</h4>
        <svg id="successAnimation" class="animated" xmlns="http://www.w3.org/2000/svg" width="180" height="180" viewBox="0 0 70 70">
            <path id="successAnimationResult" fill="#D8D8D8" d="M35,60 C21.1928813,60 10,48.8071187 10,35 C10,21.1928813 21.1928813,10 35,10 C48.8071187,10 60,21.1928813 60,35 C60,48.8071187 48.8071187,60 35,60 Z M23.6332378,33.2260427 L22.3667622,34.7739573 L34.1433655,44.40936 L47.776114,27.6305926 L46.223886,26.3694074 L33.8566345,41.59064 L23.6332378,33.2260427 Z"/>
            <circle id="successAnimationCircle" cx="35" cy="35" r="24" stroke="#979797" stroke-width="2" stroke-linecap="round" fill="transparent"/>
            <polyline id="successAnimationCheck" stroke="#979797" stroke-width="2" points="23 34 34 43 47 27" fill="transparent"/>
        </svg>
        <p>Sua transferência PIX foi confirmada!<br>O seu pedido já está sendo separado e logo será enviado para seu endereço.</p>
    </div>
    <div id="watingPixPaymentBox" style="display: <?php echo $paid ? 'none' : 'block'; ?>;">
        <h4>Faça o pagamento para finalizar!</h4>
        <p>Escaneie o código QR ou copie o código abaixo para fazer o PIX.<br> O sistema vai detectar automáticamente quando fizer a transferência.</p>
        <button class="btn btn-primary copy-qr-code">Clique aqui para copiar o código</button>
        <p class="text-success mt-4 qrcode-copyed" style="display: none;">Código copiado com sucesso!<br>Vá até o aplicativo do seu banco e cole o código.</p>
        <div>
            <img src="<?php echo (new QRCode)->render($qr_code); ?>" />
        </div>
        <!--<h5 class="mt-4">Código:</h5>
        <div><?php echo $qr_code; ?></div>-->
        <div><input type="hidden" value="<?php echo $qr_code; ?>" id="pixQrCodeInput"></div>
        <input type="hidden" name="wc_pagarme_pix_order_key" value="<?php echo $_GET['key']; ?>"/>
    </div>
</div>
