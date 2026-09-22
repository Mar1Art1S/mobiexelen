<!doctype html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Нове замовлення</title>
</head>
<body style="margin:0;background:#f4f6f3;color:#20251f;font-family:Arial,sans-serif">
    <div style="max-width:680px;margin:0 auto;padding:24px 14px">
        <div style="padding:22px;border-radius:18px;background:#ffffff">
            <p style="margin:0 0 6px;color:#a36d00;font-size:12px;font-weight:700;text-transform:uppercase">Нове замовлення з сайту</p>
            <h1 style="margin:0 0 20px;font-size:26px">{{ $order['customer_name'] }}</h1>

            <table role="presentation" style="width:100%;margin-bottom:22px;border-collapse:collapse;font-size:14px">
                <tr><td style="padding:6px 0;color:#747b76">Телефон</td><td style="padding:6px 0;text-align:right;font-weight:700">{{ $order['customer_phone'] }}</td></tr>
                <tr><td style="padding:6px 0;color:#747b76">Email</td><td style="padding:6px 0;text-align:right;font-weight:700">{{ $order['customer_email'] ?: 'Не вказано' }}</td></tr>
                <tr><td style="padding:6px 0;color:#747b76">Доставка</td><td style="padding:6px 0;text-align:right;font-weight:700">{{ $order['delivery_method'] }}</td></tr>
                <tr><td style="padding:6px 0;color:#747b76">Місто</td><td style="padding:6px 0;text-align:right;font-weight:700">{{ $order['city'] }}</td></tr>
                <tr><td style="padding:6px 0;color:#747b76">Адреса / відділення</td><td style="padding:6px 0;text-align:right;font-weight:700">{{ $order['delivery_address'] }}</td></tr>
            </table>

            <h2 style="margin:0 0 10px;font-size:18px">Товари</h2>
            <table role="presentation" style="width:100%;border-collapse:collapse;font-size:14px">
                @foreach ($order['items'] as $item)
                    <tr style="border-bottom:1px solid #edf0ec">
                        <td style="padding:11px 0">{{ $item['name'] }}<br><small style="color:#747b76">{{ number_format((int) str_replace(' ', '', $item['price']), 0, '', ' ') }} грн × {{ $item['quantity'] }}</small></td>
                        <td style="padding:11px 0;text-align:right;font-weight:700;white-space:nowrap">{{ number_format($item['subtotal'], 0, '', ' ') }} грн</td>
                    </tr>
                @endforeach
            </table>

            <p style="margin:18px 0;font-size:22px;font-weight:800;text-align:right">Разом: {{ number_format($order['total'], 0, '', ' ') }} грн</p>

            @if ($order['comment'])
                <div style="padding:14px;border-radius:12px;background:#fff8dc">
                    <strong>Коментар:</strong><br>{{ $order['comment'] }}
                </div>
            @endif

            <p style="margin:20px 0 0;color:#747b76;font-size:12px">Надіслано {{ $order['submitted_at']->format('d.m.Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
