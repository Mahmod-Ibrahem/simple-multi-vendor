<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اركان الاسرة ArkanAlosrah</title>
    <link rel="icon" type="image/png" href="logo.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/intro.css') }}">
</head>

<body>

    <nav class="navbar">
        <div class="nav-container">
            <div class="menu-toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>

            <ul class="nav-menu" id="nav-list">
                <li><a href="#" class="active">الرئيسية</a></li>
                <li><a href="#goals">أهدافنا</a></li>
                <li><a href="{{ route('home') }}" class="shop-trigger">المتجر</a></li>
                <li><a href="{{ route('register') }}">تسجيل</a></li>
                <li><a href="#policies">السياسات والأحكام</a></li>
                <li><a href="#contact">اتصل بنا</a></li>

            </ul>

            <div class="logo-area">
                <img src="logo.jpg" alt="Arkan Logo">
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <span class="badge">منصة الأسر المنتجة الأولى</span>
            <h1>منصة <span>اركان الاسرة</span></h1>
            <p>منصة أركان الأسرة هي مبادرة رقمية وطنية تهدف إلى إعادة تعريف مفهوم العمل المنزلي في المملكة العربية
                السعودية. نؤمن بأن كل أسرة هي ركن أساسي في بناء اقتصاد الوطن، ولذلك صممنا هذه المنصة لتكون الجسر الذي
                يربط إبداع الأسر المنتجة بالفرص الحقيقية في السوق.</p>
            <div class="hero-btns">
                <a href="{{ route('register') }}" target="_blank" class="btn-registration">تسجيل</a>
                <a href="{{ route('home') }}" class="btn-browse shop-trigger">تصفح المتجر</a>
            </div>
        </div>
    </section>

    <section id="goals" class="goals">
        <div class="container">
            <div class="section-head">
                <h2>لماذا أركان الأسرة؟</h2>
                <div class="line"></div>
                <div class="goals-grid">
                    <div class="goal-item">
                        <div style="font-size: 2rem; font-weight: 900; color: #e1e8f0; margin-bottom: 15px;">01</div>
                        <h3>تمكين تقني</h3>
                        <p>توفير متجر إلكتروني سهل وبسيط لكل أسرة لبيع منتجاتها وتدبير مبيعاتها.</p>
                    </div>

                    <div class="goal-item">
                        <div style="font-size: 2rem; font-weight: 900; color: #e1e8f0; margin-bottom: 15px;">02</div>
                        <h3>بيع مجاني</h3>
                        <p>فتح المجال للأسر لعرض منتجاتها وبيعها للمستهلكين بدون أي رسوم تأسيسية.</p>
                    </div>

                    <div class="goal-item">
                        <div style="font-size: 2rem; font-weight: 900; color: #e1e8f0; margin-bottom: 15px;">03</div>
                        <h3>نمو مستدام</h3>
                        <p>بناء شراكات مع جهات مختلفة توفر الدعم والتدريب لضمان استمرار مشاريع الأسر.</p>
                    </div>
                </div>
    </section>
    <section id="faq" class="goals">
        <div class="container">
            <div class="section-head">
                <h2>الأسئلة الشائعة</h2>
                <div class="line"></div>
            </div>

            <div class="faq-container">
                <div class="faq-item">
                    <button class="faq-question">كيف يمكنني التسجيل كبائع؟</button>
                    <div class="faq-answer">
                        <p>ببساطة عبر الضغط على زر "تسجيل" في الصفحة الرئيسية واتباع الخطوات المطلوبة لإنشاء متجرك.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">هل توجد رسوم على المبيعات؟</button>
                    <div class="faq-answer">
                        <p>حالياً المنصة توفر ميزة البيع المجاني للأسر المنتجة لدعمهم في بداية مشوارهم التجاري.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">كيف يتم شحن المنتجات؟</button>
                    <div class="faq-answer">
                        <p>حاليا لا يوجد خيارات توصيل والمنصة تكتفي بعرض المنتجات فقط وسيتم توفير نقاط استلام مستقبلا
                            باذن الله.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">كيف يمكنني الشراء من المنصة؟</button>
                    <div class="faq-answer">
                        <p>عن طريق النقر على زر المتجر وتصفح المنتجات ومن ثم تنقر على زر تواصل مع البائع</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">ماهي طرق الدفع؟</button>
                    <div class="faq-answer">
                        <p>لا توجد طرق دفع في المنصة, فكرة وهدف المنصة هي اظهار وعرض منتحجات الاسر فقط</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="policies" class="goals">
        <div class="container">
            <div class="section-head">
                <h2>السياسات والأحكام</h2>
                <div class="line"></div>
            </div>

            <div class="faq-container">
                <div class="faq-item">
                    <button class="faq-question">شروط وبنود الاستخدام</button>
                    <div class="faq-answer">
                        <p>تعتبر منصة "أركان الأسرة" مساحة إلكترونية مخصصة لعرض منتجات الأسر المنتجة فقط. باستخدامك
                            للمنصة، فإنك تقر بأن العلاقة التعاقدية تتم مباشرة بين البائع والمشتري دون أدنى مسؤولية على
                            المنصة في تفاصيل البيع أو الاتفاقات الجانبية.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">سياسة الخصوصية</button>
                    <div class="faq-answer">
                        <p>نحن نلتزم بحماية بيانات المستخدمين المسجلة لدينا. تُستخدم البيانات فقط لغرض تحسين تجربة العرض
                            والتواصل بين الأطراف، ولا يتم مشاركتها مع أي جهات خارجية إلا بموافقة المستخدم أو لأغراض
                            تنظيمية رسمية.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">إخلاء مسؤولية (هام)</button>
                    <div class="faq-answer">
                        <p>ينحصر دور منصة "أركان الأسرة" في العرض والإعلان فقط. المنصة لا تملك المنتجات، ولا تتدخل في
                            عمليات الشحن، الدفع، أو ضمان جودة المنتج. أي خلاف ينشأ عن عملية تجارية هو مسؤولية الأطراف
                            المعنية (البائع والمشتري) بشكل كامل، ولا تتحمل المنصة أي تبعات مالية أو قانونية حيال ذلك.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </section>
    <section id="contact" class="goals" style="background-color: var(--white);">
        <div class="container">
            <div class="section-head">
                <h2>تواصل معنا</h2>
                <div class="line"></div>
            </div>
            <div class="goals-grid">
                <div class="goal-item">
                    <div style="margin-bottom: 20px;">
                        <svg width="45" height="45" viewBox="0 0 24 24" fill="none" stroke="var(--dark)"
                            stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                            </path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                    <h3>البريد الإلكتروني</h3>
                    <p style="direction: ltr; font-weight: bold; color: var(--primary);">info@arkanalosrah.com</p>
                </div>

                <div class="goal-item">
                    <div style="margin-bottom: 20px;">
                        <svg width="45" height="45" viewBox="0 0 24 24" fill="none" stroke="var(--dark)"
                            stroke-width="2">
                            <rect x="5" y="2" width="14" height="20"></rect>
                            <line x1="12" y1="18" x2="12.01" y2="18"></line>
                        </svg>
                    </div>
                    <h3>رقم الجوال</h3>
                    <p style="direction: ltr; font-weight: bold; color: var(--primary);">0532263042</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-wrap">
                <p>&copy; جميع الحقوق محفوظه لمنصة اركان الاسرة</p>
                <p>رقم الترخيص : 302932379</p>

            </div>
        </div>
    </footer>

    <script>
        // 1. كود القائمة والأسئلة الشائعة الأصلي
        const menu = document.getElementById('mobile-menu');
        const navList = document.getElementById('nav-list');
        menu.addEventListener('click', () => {
            navList.classList.toggle('active');
            menu.classList.toggle('is-active');
        });
        const acc = document.getElementsByClassName("faq-question");
        for (let i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function () {
                this.classList.toggle("active-faq");
                const panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }


    </script>
</body>

</html>