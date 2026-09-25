<style>
.auth-top-nav { width: 100%; max-width: 460px; display: flex; align-items: center; justify-content: flex-start; }
.auth-back-link { display: inline-flex; align-items: center; gap: 8px; color: #94a3b8; text-decoration: none; font-size: 0.84rem; font-weight: 600; padding: 6px 14px; border-radius: 50px; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.08); transition: all 0.22s ease; backdrop-filter: blur(8px); }
.auth-back-link:hover { color: #ffffff; background: rgba(255, 42, 133, 0.14); border-color: rgba(255, 42, 133, 0.35); transform: translateX(-3px); }

.auth-card { width: 100%; max-width: 460px; background: rgba(18, 22, 33, 0.88); backdrop-filter: blur(24px); border-radius: 24px; border: 1px solid rgba(255, 42, 133, 0.22); box-shadow: 0 24px 60px rgba(0, 0, 0, 0.55), 0 0 40px rgba(255, 42, 133, 0.08); padding: 38px 34px; color: #ffffff; position: relative; overflow: hidden; }
.auth-card::before { content: ''; position: absolute; top: 0; left: 12%; right: 12%; height: 2px; background: linear-gradient(90deg, transparent, var(--srl-pink), var(--srl-pink-glow), transparent); }

.otp-icon-badge { width: 76px; height: 76px; border-radius: 50%; background: var(--srl-pink-gradient); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 8px 28px rgba(255, 42, 133, 0.42), 0 0 0 6px rgba(255, 42, 133, 0.08); font-size: 2rem; color: #ffffff; animation: otpPulse 2.4s ease-in-out infinite; }

@keyframes otpPulse {
  0%, 100% { box-shadow: 0 8px 28px rgba(255, 42, 133, 0.42), 0 0 0 6px rgba(255, 42, 133, 0.08); }
  50%      { box-shadow: 0 8px 32px rgba(255, 42, 133, 0.55), 0 0 0 10px rgba(255, 42, 133, 0.12); }
}

.auth-logo-header { text-align: center; margin-bottom: 8px; }
.auth-title { font-size: 1.5rem; font-weight: 800; color: #ffffff; margin: 0 0 6px; text-align: center; letter-spacing: -0.3px; }
.auth-subtitle { font-size: 0.88rem; color: #94a3b8; margin: 0 0 6px; line-height: 1.45; text-align: center; }

.otp-phone-display { text-align: center; font-size: 0.95rem; font-weight: 700; color: var(--srl-pink-glow); margin-bottom: 28px; }

.otp-input-row { display: flex; justify-content: center; gap: 10px; margin-bottom: 8px; }
.otp-digit-box { width: 52px; height: 58px; text-align: center; font-size: 1.5rem; font-weight: 800; color: #ffffff; background-color: rgba(18, 22, 34, 0.85); border: 1.5px solid rgba(255, 255, 255, 0.15); border-radius: 12px; transition: all 0.22s ease; caret-color: var(--srl-pink-glow); }
.otp-digit-box:focus { outline: none; background-color: rgba(15, 19, 32, 0.98); border-color: var(--srl-pink); box-shadow: 0 0 0 3px rgba(255, 42, 133, 0.25), 0 0 16px rgba(255, 42, 133, 0.15); transform: translateY(-2px); }
.otp-digit-box.filled { border-color: rgba(255, 42, 133, 0.5); }
.otp-digit-box.error-shake { animation: shakeError 0.4s ease; border-color: #ef4444 !important; }

@keyframes shakeError {
  0%, 100% { transform: translateX(0); }
  20%, 60% { transform: translateX(-6px); }
  40%, 80% { transform: translateX(6px); }
}

@media (max-width: 400px) {
  .otp-digit-box { width: 42px; height: 50px; font-size: 1.25rem; }
  .otp-input-row { gap: 7px; }
}

.otp-timer-row { text-align: center; margin: 6px 0 24px; font-size: 0.86rem; color: #94a3b8; }
.otp-timer-count { color: var(--srl-pink-glow); font-weight: 700; }
.otp-resend-link { color: var(--srl-pink-glow); font-weight: 700; text-decoration: none; cursor: pointer; transition: all 0.2s ease; }
.otp-resend-link:hover { text-decoration: underline; color: #ffffff; }
.otp-resend-link.disabled { color: #475569; cursor: not-allowed; pointer-events: none; text-decoration: none; }

.auth-btn-submit { width: 100%; padding: 13px; border-radius: 12px; background: var(--srl-pink-gradient); border: none; color: #ffffff; font-size: 1rem; font-weight: 700; letter-spacing: 0.2px; box-shadow: 0 4px 20px rgba(255, 42, 133, 0.38); transition: all 0.25s ease; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; }
.auth-btn-submit:hover { box-shadow: 0 8px 30px rgba(255, 42, 133, 0.55); transform: translateY(-2px); color: #ffffff; }
.auth-btn-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

.auth-footer-text { text-align: center; font-size: 0.88rem; color: #94a3b8; margin-top: 22px; }
.auth-switch-link { color: var(--srl-pink-glow) !important; font-weight: 700; text-decoration: none; }
.auth-switch-link:hover { text-decoration: underline; }

.otp-attempts-hint { text-align: center; font-size: 0.76rem; color: #64748b; margin-top: 10px; }

@media (max-width: 575.98px) {
  .auth-card { padding: 28px 20px; border-radius: 20px; }
  .auth-title { font-size: 1.32rem; }
}
</style>

<?php
$back_url   = ($otp_type === 'register') ? base_url('register') : base_url('login');
$back_label = ($otp_type === 'register') ? 'Back to Registration' : 'Back to Login';
$title_text = ($otp_type === 'register') ? 'Verify Your Mobile Number' : 'Verify Your Login';
$btn_text   = ($otp_type === 'register') ? 'Verify & Create Account' : 'Verify & Sign In';
?>

<div class="auth-top-nav mb-3">
  <a href="<?= $back_url ?>" class="auth-back-link">
    <i class="bi bi-arrow-left"></i>
    <span><?= $back_label ?></span>
  </a>
</div>

<div class="auth-card">

  <div class="otp-icon-badge">
    <i class="bi bi-shield-lock-fill"></i>
  </div>

  <div class="auth-logo-header">
    <h4 class="auth-title"><?= $title_text ?></h4>
    <p class="auth-subtitle">We've sent a 6-digit verification code via SMS to</p>
  </div>

  <div class="otp-phone-display">
    <i class="bi bi-telephone-fill me-1"></i><?= html_escape($masked_phone) ?>
  </div>

  <?= form_open('verify-otp', ['id' => 'otpForm']) ?>
    <input type="hidden" name="otp" id="otpHiddenInput">

    <div class="otp-input-row" id="otpInputRow">
      <input type="text" inputmode="numeric" maxlength="1" class="otp-digit-box" data-index="0" autofocus>
      <input type="text" inputmode="numeric" maxlength="1" class="otp-digit-box" data-index="1">
      <input type="text" inputmode="numeric" maxlength="1" class="otp-digit-box" data-index="2">
      <input type="text" inputmode="numeric" maxlength="1" class="otp-digit-box" data-index="3">
      <input type="text" inputmode="numeric" maxlength="1" class="otp-digit-box" data-index="4">
      <input type="text" inputmode="numeric" maxlength="1" class="otp-digit-box" data-index="5">
    </div>

    <div class="otp-timer-row">
      <span id="resendTimerWrap">
        Resend code in <span class="otp-timer-count" id="resendCountdown">60</span>s
      </span>
      <a href="#" class="otp-resend-link disabled" id="resendOtpLink" style="display:none;">
        <i class="bi bi-arrow-repeat me-1"></i>Resend OTP
      </a>
    </div>

    <button type="submit" class="auth-btn-submit" id="btnVerifyOtp">
      <i class="bi bi-check-circle-fill"></i>
      <span><?= $btn_text ?></span>
    </button>

    <p class="otp-attempts-hint">
      <i class="bi bi-info-circle me-1"></i>Code expires in 10 minutes. Max 5 attempts allowed.
    </p>
  <?= form_close() ?>

  <div class="auth-footer-text">
    <span>Wrong number?</span>
    <a href="<?= $back_url ?>" class="auth-switch-link ms-1">Start Over</a>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const boxes = document.querySelectorAll('.otp-digit-box');
  const hiddenInput = document.getElementById('otpHiddenInput');
  const otpForm = document.getElementById('otpForm');

  boxes.forEach((box, idx) => {
    box.addEventListener('input', function () {
      this.value = this.value.replace(/[^0-9]/g, '');
      if (this.value) {
        this.classList.add('filled');
        if (idx < boxes.length - 1) boxes[idx + 1].focus();
      } else {
        this.classList.remove('filled');
      }
      updateHiddenOtp();
    });

    box.addEventListener('keydown', function (e) {
      if (e.key === 'Backspace' && !this.value && idx > 0) {
        boxes[idx - 1].focus();
      }
    });

    box.addEventListener('paste', function (e) {
      e.preventDefault();
      const pasteData = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');
      if (pasteData.length) {
        boxes.forEach((b, i) => {
          b.value = pasteData[i] || '';
          if (b.value) b.classList.add('filled');
        });
        updateHiddenOtp();
        const lastFilled = Math.min(pasteData.length, boxes.length) - 1;
        if (lastFilled >= 0) boxes[lastFilled].focus();
      }
    });
  });

  function updateHiddenOtp() {
    let otp = '';
    boxes.forEach(b => otp += b.value);
    hiddenInput.value = otp;
  }

  function shakeError() {
    boxes.forEach(b => {
      b.classList.add('error-shake');
      setTimeout(() => b.classList.remove('error-shake'), 400);
    });
  }

  <?php if ($this->session->flashdata('error')): ?>
    shakeError();
  <?php endif; ?>

  otpForm.addEventListener('submit', function (e) {
    updateHiddenOtp();
    if (hiddenInput.value.length !== 6) {
      e.preventDefault();
      shakeError();
      Swal.fire({
        title: 'Incomplete Code',
        text: 'Please enter all 6 digits of the OTP.',
        icon: 'warning',
        customClass: { popup: 'srl-swal-popup' }
      });
      return;
    }
    const btn = document.getElementById('btnVerifyOtp');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Verifying...';
  });

  let secondsLeft = <?= (int)$resend_wait ?: 60 ?>;
  const countdownEl = document.getElementById('resendCountdown');
  const timerWrap = document.getElementById('resendTimerWrap');
  const resendLink = document.getElementById('resendOtpLink');

  function tickTimer() {
    if (secondsLeft <= 0) {
      timerWrap.style.display = 'none';
      resendLink.style.display = 'inline-flex';
      resendLink.classList.remove('disabled');
      return;
    }
    countdownEl.innerText = secondsLeft;
    secondsLeft--;
    setTimeout(tickTimer, 1000);
  }
  tickTimer();

  resendLink.addEventListener('click', function (e) {
    e.preventDefault();
    if (this.classList.contains('disabled')) return;

    this.classList.add('disabled');
    this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Sending...';

    fetch('<?= base_url('resend-otp') ?>', {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        Swal.fire({
          title: 'OTP Resent!',
          text: data.message,
          icon: 'success',
          customClass: { popup: 'srl-swal-popup' }
        });
        boxes.forEach(b => { b.value = ''; b.classList.remove('filled'); });
        boxes[0].focus();

        secondsLeft = 60;
        resendLink.style.display = 'none';
        timerWrap.style.display = 'inline';
        tickTimer();
      } else {
        if (data.redirect) {
          window.location.href = data.redirect;
          return;
        }
        Swal.fire({
          title: 'Notice',
          text: data.message,
          icon: 'warning',
          customClass: { popup: 'srl-swal-popup' }
        });
        this.classList.remove('disabled');
        this.innerHTML = '<i class="bi bi-arrow-repeat me-1"></i>Resend OTP';
      }
    })
    .catch(() => {
      this.classList.remove('disabled');
      this.innerHTML = '<i class="bi bi-arrow-repeat me-1"></i>Resend OTP';
    });
  });
});
</script>