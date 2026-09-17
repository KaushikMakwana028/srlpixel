<?php
// Function to convert amount to Indian Rupee Words
if (!function_exists('numberToWordsINR')) {
    function numberToWordsINR($number) {
        $no = floor($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            '0' => '', '1' => 'One', '2' => 'Two', '3' => 'Three', '4' => 'Four',
            '5' => 'Five', '6' => 'Six', '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
            '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve', '13' => 'Thirteen',
            '14' => 'Fourteen', '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
            '18' => 'Eighteen', '19' => 'Nineteen', '20' => 'Twenty', '30' => 'Thirty',
            '40' => 'Forty', '50' => 'Fifty', '60' => 'Sixty', '70' => 'Seventy',
            '80' => 'Eighty', '90' => 'Ninety'
        );
        $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred
                    : $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[$counter] . $plural . " " . $hundred;
            } else {
                $str[] = null;
            }
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ? " and " . $words[floor($point / 10) * 10] . " " . $words[$point = $point % 10] . " Paise" : '';
        return ($result ? trim($result) : 'Zero') . " Rupees" . $points . " Only";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tax Invoice #<?= html_escape($order->order_number) ?> - SRL Pixel</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background-color: #f1f5f9;
      color: #1e293b;
      margin: 0;
      padding: 0;
    }

    /* Floating Screen Action Bar */
    .invoice-action-bar {
      background: #0f172a;
      color: #ffffff;
      padding: 12px 24px;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* A4 Invoice Paper Container */
    .invoice-sheet {
      width: 100%;
      max-width: 850px;
      margin: 30px auto;
      background: #ffffff;
      border: 1px solid #cbd5e1;
      border-radius: 12px;
      padding: 40px 45px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      position: relative;
    }

    .invoice-brand-logo {
      max-height: 48px;
      width: auto;
      object-fit: contain;
    }

    .table-invoice th {
      background-color: #f8fafc;
      color: #475569;
      font-size: 0.76rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      border-bottom: 2px solid #e2e8f0;
      padding: 10px 12px;
    }

    .table-invoice td {
      padding: 10px 12px;
      font-size: 0.86rem;
      vertical-align: middle;
      border-bottom: 1px solid #f1f5f9;
    }

    .invoice-badge-paid {
      border: 2px solid #10b981;
      color: #059669;
      background: #ecfdf5;
      font-weight: 800;
      letter-spacing: 1px;
      padding: 6px 14px;
      border-radius: 8px;
      display: inline-block;
      text-transform: uppercase;
      font-size: 0.78rem;
    }

    .invoice-badge-pending {
      border: 2px solid #f59e0b;
      color: #d97706;
      background: #fffbeb;
      font-weight: 800;
      letter-spacing: 1px;
      padding: 6px 14px;
      border-radius: 8px;
      display: inline-block;
      text-transform: uppercase;
      font-size: 0.78rem;
    }

    /* Print-Only Optimization */
    @media print {
      body {
        background: #ffffff !important;
        color: #000000 !important;
        margin: 0 !important;
        padding: 0 !important;
      }

      .invoice-action-bar {
        display: none !important;
      }

      .invoice-sheet {
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
        width: 100% !important;
        max-width: 100% !important;
      }

      @page {
        size: A4 portrait;
        margin: 12mm 12mm 12mm 12mm;
      }

      .table-invoice th {
        background-color: #f1f5f9 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }
    }
  </style>
</head>
<body>

  <!-- Top Action Toolbar (Hidden during printing) -->
  <div class="invoice-action-bar d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="d-flex align-items-center gap-2">
      <span class="badge bg-danger px-2 py-1" style="background: #e11d74 !important;">SRL PIXEL</span>
      <span class="fw-bold">Tax Invoice #<?= html_escape($order->order_number) ?></span>
    </div>

    <div class="d-flex align-items-center gap-2">
      <!-- Print / Download PDF Button -->
      <button type="button" class="btn btn-light btn-sm fw-bold px-3 py-1 rounded-pill shadow-sm" onclick="window.print()">
        <i class="bi bi-printer-fill me-1 text-primary"></i>Print / Save as PDF
      </button>

      <?php if (!empty($is_admin)): ?>
        <a href="<?= base_url('admin/orders/detail/' . $order->id) ?>" class="btn btn-outline-light btn-sm rounded-pill px-3 py-1">
          <i class="bi bi-arrow-left me-1"></i>Back to Order
        </a>
      <?php else: ?>
        <a href="<?= base_url('profile/order/' . $order->id) ?>" class="btn btn-outline-light btn-sm rounded-pill px-3 py-1">
          <i class="bi bi-arrow-left me-1"></i>Back to Order
        </a>
      <?php endif; ?>
    </div>
  </div>

  <!-- A4 Printable Invoice Sheet -->
  <div class="invoice-sheet">
    <!-- Invoice Header -->
    <div class="d-flex justify-content-between align-items-start border-bottom pb-4 mb-4 flex-wrap gap-3">
      <div>
        <img src="<?= base_url('assets/images/new_logo.png') ?>" alt="SRL Pixel Logo" class="invoice-brand-logo mb-2" onerror="this.onerror=null; this.src='<?= base_url('assets/images/logo.png') ?>';">
        <h5 class="fw-extrabold text-dark mb-0" style="letter-spacing: -0.3px;"><?= defined('COMPANY_NAME') ? COMPANY_NAME : "SRL PIXEL LED'S GLOWING HUB" ?></h5>
        <small class="text-secondary d-block"><?= defined('COMPANY_TAGLINE') ? COMPANY_TAGLINE : "India's Premier Addressable RGB & Pixel LED Specialists" ?></small>
        <div class="small text-muted mt-2" style="line-height: 1.45;">
          <?= defined('COMPANY_ADDRESS') ? COMPANY_ADDRESS : "12, Electronica Hub, Nobal Nagar, Ahmedabad, Gujarat - 382340" ?><br>
          <strong>GSTIN:</strong> <?= defined('COMPANY_GSTIN') ? COMPANY_GSTIN : "24AAACS7890F1Z5" ?> &bull; <strong>State Code:</strong> 24 (Gujarat)<br>
          <strong>Email:</strong> <?= defined('COMPANY_EMAIL') ? COMPANY_EMAIL : "support@srlpixel.com" ?> &bull; <strong>Phone:</strong> <?= defined('COMPANY_PHONE') ? COMPANY_PHONE : "+91 90997 80463" ?>
        </div>
      </div>

      <div class="text-end">
        <div class="text-uppercase fw-extrabold fs-4 text-dark mb-1" style="letter-spacing: 1px;">TAX INVOICE</div>
        <div class="small mb-1">
          <span class="text-muted">Invoice No:</span> <strong class="text-dark">INV-<?= html_escape($order->order_number) ?></strong>
        </div>
        <div class="small mb-1">
          <span class="text-muted">Invoice Date:</span> <strong class="text-dark"><?= date('d M Y', strtotime($order->created_at)) ?></strong>
        </div>
        <div class="small mb-2">
          <span class="text-muted">Order ID:</span> <strong class="text-dark">#<?= html_escape($order->order_number) ?></strong>
        </div>

        <?php if ($order->payment_status === 'Paid'): ?>
          <div class="invoice-badge-paid"><i class="bi bi-check-circle-fill me-1"></i>PAID IN FULL</div>
        <?php else: ?>
          <div class="invoice-badge-pending"><i class="bi bi-clock-history me-1"></i><?= strtoupper(html_escape($order->payment_method)) ?> (<?= strtoupper(html_escape($order->payment_status)) ?>)</div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Bill To & Ship To 2-Column Info -->
    <div class="row g-4 mb-4 pb-3 border-bottom">
      <!-- Billed To -->
      <div class="col-6">
        <div class="text-uppercase small fw-bold text-muted mb-2" style="font-size: 0.72rem; letter-spacing: 0.8px;">
          <i class="bi bi-person-fill me-1 text-primary"></i>BILLED TO
        </div>
        <strong class="text-dark fs-6 d-block"><?= $customer ? html_escape($customer->name) : html_escape($order->shipping_full_name) ?></strong>
        <div class="text-secondary small mb-1">
          <i class="bi bi-telephone me-1"></i><?= html_escape($order->shipping_mobile) ?>
        </div>
        <?php if ($customer && !empty($customer->email)): ?>
          <div class="text-secondary small mb-1">
            <i class="bi bi-envelope me-1"></i><?= html_escape($customer->email) ?>
          </div>
        <?php endif; ?>
        <?php if ($customer && !empty($customer->shop_name)): ?>
          <div class="text-secondary small">
            <strong>Business/Shop:</strong> <?= html_escape($customer->shop_name) ?>
          </div>
        <?php endif; ?>
        <?php if ($customer && !empty($customer->gst_number)): ?>
          <div class="text-secondary small">
            <strong>Customer GSTIN:</strong> <?= html_escape($customer->gst_number) ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Shipped To -->
      <div class="col-6">
        <div class="text-uppercase small fw-bold text-muted mb-2" style="font-size: 0.72rem; letter-spacing: 0.8px;">
          <i class="bi bi-geo-alt-fill me-1 text-danger"></i>SHIPPED TO (DELIVERY ADDRESS)
        </div>
        <strong class="text-dark fs-6 d-block"><?= html_escape($order->shipping_full_name) ?></strong>
        <div class="text-secondary small mb-1">
          <i class="bi bi-telephone me-1"></i><?= html_escape($order->shipping_mobile) ?>
        </div>
        <p class="text-secondary small mb-0" style="line-height: 1.45;">
          <?= html_escape($order->shipping_address_line1) ?><br>
          <?php if (!empty($order->shipping_address_line2)): ?>
            <?= html_escape($order->shipping_address_line2) ?><br>
          <?php endif; ?>
          <?php if (!empty($order->shipping_landmark)): ?>
            Landmark: <?= html_escape($order->shipping_landmark) ?><br>
          <?php endif; ?>
          <?= html_escape($order->shipping_city) ?>, <?= html_escape($order->shipping_state) ?> - <strong><?= html_escape($order->shipping_pincode) ?></strong><br>
          <?= html_escape($order->shipping_country) ?>
        </p>
      </div>
    </div>

    <!-- Items Table -->
    <div class="table-responsive mb-4">
      <table class="table table-invoice mb-0">
        <thead>
          <tr>
            <th style="width: 40px;" class="text-center">#</th>
            <th>Item Description</th>
            <th style="width: 110px;">SKU</th>
            <th style="width: 100px;" class="text-end">Unit Price</th>
            <th style="width: 70px;" class="text-center">Qty</th>
            <th style="width: 120px;" class="text-end">Total (₹)</th>
          </tr>
        </thead>
        <tbody>
          <?php $idx = 1; foreach ($items as $item): ?>
            <tr>
              <td class="text-center text-muted small"><?= $idx++ ?></td>
              <td>
                <strong class="text-dark d-block"><?= html_escape($item->product_name) ?></strong>
                <small class="text-muted">HSN/SAC: 94054090 &bull; 100% Tested LED Module</small>
              </td>
              <td>
                <span class="badge bg-light text-dark border small"><?= !empty($item->sku) ? html_escape($item->sku) : '—' ?></span>
              </td>
              <td class="text-end">₹<?= number_format($item->unit_price, 2) ?></td>
              <td class="text-center fw-bold">× <?= (int)$item->quantity ?></td>
              <td class="text-end fw-bold text-dark">₹<?= number_format($item->line_total, 2) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Calculations Summary (Subtotal, Shipping, Grand Total - CGST/SGST removed as requested) -->
    <div class="row g-4 mb-4">
      <!-- Amount in Words -->
      <div class="col-sm-7">
        <div class="p-3 rounded-3 bg-light border mb-3">
          <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.72rem;">Total Amount in Words:</small>
          <strong class="text-dark small"><?= numberToWordsINR($order->total_amount) ?></strong>
        </div>

        <div class="small text-muted" style="line-height: 1.45;">
          <strong>Payment Mode:</strong> <?= html_escape($order->payment_method) ?><br>
          <?php if (!empty($order->razorpay_payment_id)): ?>
            <strong>Razorpay Payment Ref:</strong> <?= html_escape($order->razorpay_payment_id) ?><br>
          <?php endif; ?>
          <strong>Status:</strong> <?= html_escape($order->payment_status) ?>
        </div>
      </div>

      <!-- Financial Calculation -->
      <div class="col-sm-5">
        <div class="p-3 rounded-3 bg-light border">
          <div class="d-flex justify-content-between py-1 small">
            <span class="text-muted">Subtotal:</span>
            <strong class="text-dark">₹<?= number_format($order->subtotal, 2) ?></strong>
          </div>
          <div class="d-flex justify-content-between py-1 small">
            <span class="text-muted">Shipping Charges:</span>
            <span class="text-success fw-bold">FREE (₹0.00)</span>
          </div>

          <hr class="my-2 border-secondary border-opacity-25">

          <div class="d-flex justify-content-between align-items-baseline pt-1">
            <span class="fw-extrabold text-dark fs-6">Grand Total:</span>
            <span class="fw-extrabold fs-5 text-danger" style="color: #e11d74 !important;">
              ₹<?= number_format($order->total_amount, 2) ?>
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Terms & Signature Footer -->
    <div class="row pt-3 border-top mt-4 align-items-end">
      <div class="col-7">
        <h6 class="fw-bold small text-dark mb-1">Terms & Conditions:</h6>
        <ol class="small text-muted ps-3 mb-0" style="font-size: 0.72rem; line-height: 1.45;">
          <li>All pixel LED items carry 7-day replacement warranty for manufacturing defects.</li>
          <li>Ensure proper DC voltage (5V / 12V / 24V) rating before connecting power supplies.</li>
          <li>This is a computer-generated GST tax invoice and requires no signature.</li>
        </ol>
      </div>
      <div class="col-5 text-end">
        <div class="small text-muted mb-4">For <strong><?= defined('COMPANY_NAME') ? COMPANY_NAME : "SRL PIXEL LED'S GLOWING HUB" ?></strong></div>
        <div class="fw-bold text-dark pt-3 border-top d-inline-block small" style="min-width: 170px;">
          Authorized Signatory
        </div>
      </div>
    </div>
  </div>

</body>
</html>
