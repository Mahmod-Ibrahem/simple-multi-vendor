<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تأكيد البريد الإلكتروني</title>
    <style>
        body {
            font-family: 'Cairo', Arial, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
            direction: rtl;
            text-align: right;
            color: #333333;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #e1e8f0;
        }

        .header {
            background-color: #145b9b;
            padding: 30px 20px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }

        .content {
            padding: 40px 30px;
        }

        .content h2 {
            font-size: 20px;
            color: #1a1a1a;
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .content p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 25px;
            color: #555555;
        }

        .btn-container {
            text-align: center;
            margin: 35px 0;
        }

        .btn {
            background-color: #145b9b;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 35px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            display: inline-block;
            box-shadow: 0 4px 10px rgba(20, 91, 155, 0.3);
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #c9710f;
        }

        .footer {
            background-color: #f8fafc;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #eee;
            font-size: 14px;
            color: #888888;
        }

        .footer p {
            margin: 5px 0;
        }

        .notice {
            font-size: 13px;
            color: #999;
            margin-top: 25px;
            border-top: 1px solid #f0f0f0;
            padding-top: 15px;
            word-break: break-all;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h1>أركان الأسرة</h1>
        </div>

        <div class="content">
            <h2>أهلاً بك، {{ $user->name ?? 'عميلنا العزيز' }}!</h2>
            <p>نحن سعداء بانضمامك إلى منصة أركان الأسرة. لتفعيل حسابك والبدء في استخدام كافة ميزاتنا، يرجى تأكيد عنوان
                بريدك الإلكتروني من خلال النقر على الزر أدناه.</p>

            <div class="btn-container">
                <a href="{{ $url }}" class="btn">تأكيد البريد الإلكتروني</a>
            </div>

            <p>إذا لم تقم بإنشاء حساب في منصتنا، فلا داعي لاتخاذ أي إجراء إضافي، ويمكنك تجاهل هذه الرسالة بأمان.</p>

            <p>مع أطيب التحيات،<br>فريق أركان الأسرة</p>

            <div class="notice">
                إذا كنت تواجه مشكلة في النقر على زر "تأكيد البريد الإلكتروني"، يمكنك نسخ ولصق الرابط التالي في متصفحك:
                <br>
                <a href="{{ $url }}" style="color: #145b9b;">{{ $url }}</a>
            </div>
        </div>

        <div class="footer">
            <p>جميع الحقوق محفوظة &copy; {{ date('Y') }} أركان الأسرة.</p>
        </div>
    </div>

</body>

</html>