<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following Service lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute باید پذیرفته شده باشد.',
    'active_url' => 'آدرس :attribute معتبر نیست.',
    'after' => ':attribute باید تاریخی بعد از :date باشد.',
    'after_or_equal' => ':attribute باید تاریخی بعد از :date، یا مطابق با آن باشد.',
    'alpha' => ':attribute باید فقط حروف الفبا باشد.',
    'alpha_dash' => ':attribute باید فقط حروف الفبا، اعداد، خط تیره و زیرخط باشد.',
    'alpha_num' => ':attribute باید فقط حروف الفبا و اعداد باشد.',
    'array' => ':attribute باید آرایه باشد.',
    'before' => ':attribute باید تاریخی قبل از :date باشد.',
    'before_or_equal' => ':attribute باید تاریخی قبل از :date، یا مطابق با آن باشد.',
    'between' => [
        'numeric' => ':attribute باید بین :min و :max باشد.',
        'file' => ':attribute باید بین :min و :max کیلوبایت باشد.',
        'string' => ':attribute باید بین :min و :max کاراکتر باشد.',
        'array' => ':attribute باید بین :min و :max آیتم باشد.',
    ],
    'boolean' => 'فیلد :attribute فقط می‌تواند true و یا false باشد.',
    'confirmed' => ':attribute با فیلد تکرار مطابقت ندارد.',
    'date' => ':attribute یک تاریخ معتبر نیست.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => ':attribute با الگوی :format مطابقت ندارد.',
    'different' => ':attribute و :other باید از یکدیگر متفاوت باشند.',
    'digits' => ':attribute باید :digits رقم باشد.',
    'digits_between' => ':attribute باید بین :min و :max رقم باشد.',
    'dimensions' => 'ابعاد تصویر :attribute قابل قبول نیست.',
    'distinct' => 'فیلد :attribute مقدار تکراری دارد.',
    'email' => ':attribute باید معتبر باشد.',
    'exists' => ':attribute انتخاب شده، معتبر نیست.',
    'file' => ':attribute باید یک فایل معتبر باشد.',
    'filled' => 'فیلد :attribute باید مقدار داشته باشد.',
    'gt' => [
        'numeric' => ':attribute باید بزرگتر از :value باشد.',
        'file' => ':attribute باید بزرگتر از :value کیلوبایت باشد.',
        'string' => ':attribute باید بیشتر از :value کاراکتر داشته باشد.',
        'array' => ':attribute باید بیشتر از :value آیتم داشته باشد.',
    ],
    'gte' => [
        'numeric' => ':attribute باید بزرگتر یا مساوی :value باشد.',
        'file' => ':attribute باید بزرگتر یا مساوی :value کیلوبایت باشد.',
        'string' => ':attribute باید بیشتر یا مساوی :value کاراکتر داشته باشد.',
        'array' => ':attribute باید بیشتر یا مساوی :value آیتم داشته باشد.',
    ],
    'image' => ':attribute باید یک تصویر معتبر باشد.',
    'in' => ':attribute انتخاب شده، معتبر نیست.',
    'in_array' => 'فیلد :attribute در لیست :other وجود ندارد.',
    'integer' => ':attribute باید عدد صحیح باشد.',
    'ip' => ':attribute باید آدرس IP معتبر باشد.',
    'ipv4' => ':attribute باید یک آدرس معتبر از نوع IPv4 باشد.',
    'ipv6' => ':attribute باید یک آدرس معتبر از نوع IPv6 باشد.',
    'json' => 'فیلد :attribute باید یک رشته از نوع JSON باشد.',
    'lt' => [
        'numeric' => ':attribute باید کوچکتر از :value باشد.',
        'file' => ':attribute باید کوچکتر از :value کیلوبایت باشد.',
        'string' => ':attribute باید کمتر از :value کاراکتر داشته باشد.',
        'array' => ':attribute باید کمتر از :value آیتم داشته باشد.',
    ],
    'lte' => [
        'numeric' => ':attribute باید کوچکتر یا مساوی :value باشد.',
        'file' => ':attribute باید کوچکتر یا مساوی :value کیلوبایت باشد.',
        'string' => ':attribute باید کمتر یا مساوی :value کاراکتر داشته باشد.',
        'array' => ':attribute باید کمتر یا مساوی :value آیتم داشته باشد.',
    ],
    'max' => [
        'numeric' => ':attribute نباید بزرگتر از :max باشد.',
        'file' => ':attribute نباید بزرگتر از :max کیلوبایت باشد.',
        'string' => ':attribute نباید بیشتر از :max کاراکتر داشته باشد.',
        'array' => ':attribute نباید بیشتر از :max آیتم داشته باشد.',
    ],
    'mimes' => 'فرمت‌های معتبر فایل عبارتند از: :values.',
    'mimetypes' => 'فرمت‌های معتبر فایل عبارتند از: :values.',
    'min' => [
        'numeric' => ':attribute نباید کوچکتر از :min باشد.',
        'file' => ':attribute نباید کوچکتر از :min کیلوبایت باشد.',
        'string' => ':attribute نباید کمتر از :min کاراکتر داشته باشد.',
        'array' => ':attribute نباید کمتر از :min آیتم داشته باشد.',
    ],
    'not_in' => ':attribute انتخاب شده، معتبر نیست.',
    'not_regex' => 'فرمت :attribute معتبر نیست.',
    'numeric' => ':attribute باید عدد یا رشته‌ای از اعداد باشد.',
    'present' => 'فیلد :attribute باید در پارامترهای ارسالی وجود داشته باشد.',
    'regex' => 'فرمت :attribute معتبر نیست.',
    'required' => ' :attribute را وارد کنید',
    'requires' => ' :attribute را انتخاب کنید',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_if' => 'فیلد :attribute هنگامی که :other برابر با :value است، الزامیست.',
    'required_with' => ':attribute الزامی است زمانی که :values موجود است.',
    'required_with_all' => ':attribute الزامی است زمانی که :values موجود است.',
    'required_without' => ':attribute الزامی است زمانی که :values موجود نیست.',
    'required_without_all' => ':attribute الزامی است زمانی که :values موجود نیست.',
    'same' => ':attribute و :other باید همانند هم باشند.',
    'size' => [
        'numeric' => ':attribute باید برابر با :size باشد.',
        'file' => ':attribute باید برابر با :size کیلوبایت باشد.',
        'string' => ':attribute باید برابر با :size کاراکتر باشد.',
        'array' => ':attribute باید شامل :size آیتم باشد.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values',
    'string' => 'فیلد :attribute باید رشته باشد.',
    'timezone' => 'فیلد :attribute باید یک منطقه زمانی معتبر باشد.',
    'unique' => ':attribute قبلا انتخاب شده است.',
    'uploaded' => 'بارگذاری فایل :attribute موفقیت آمیز نبود.',
    'url' => ':attribute معتبر نمی‌باشد.',
    'uuid' => 'The :attribute must be a valid UUID.',
    'captcha'=>'کپچا را دوباره انتخاب کنید.',
    'latin'=>'اعداد و کاراکترهای غیر لاتین مجاز نیست.',
    'farsi'=>' لطفا از حروف فارسی استفاده نمایید.',
    'nationalcode'=>' کد ملی صحیح نیست.',
    'adults'=>' سن بزرگسال باید بزرگتر از 12 سال باشد.',
    'children'=>' سن کودک باید بین 2 تا 12 سال باشد.',
    'baby'=>'سن نوزاد باید بین 10 روز تا 2 سال باشد.',
    'mobile'=>'شماره تلفن همراه وارد شده صحیح نیست.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom Service line for a given attribute rule.
    |
    */

    'custom' => [
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following Service lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' => 'نام',
        'ename' => 'نام لاتین',
        'fname' => 'نام',
        'lname' => 'نام خانوادگی',
        'username' => 'نام کاربری',
        'email' => 'ایمیل',
        'first_name' => 'نام',
        'last_name' => 'نام خانوادگی',
        'password' => 'رمز عبور',
        'password_confirmation' => 'تاییدیه ی رمز عبور',
        'city' => 'شهر',
        'country' => 'کشور',
        'address' => 'نشانی',
        'phone' => 'تلفن',
        'mobile' => 'شماره تلفن همراه',
        'age' => 'سن',
        'sex' => 'جنسیت',
        'gender' => 'جنسیت',
        'day' => 'روز',
        'month' => 'ماه',
        'year' => 'سال',
        'hour' => 'ساعت',
        'image' => 'تصویر',
        'minute' => 'دقیقه',
        'second' => 'ثانیه',
        'title' => 'عنوان',
        'text' => 'متن',
        'content' => 'محتوا',
        'description' => 'توضیحات',
        'excerpt' => 'گلچین کردن',
        'date' => 'تاریخ',
        'time' => 'زمان',
        'available' => 'موجود',
        'size' => 'اندازه',
        'name_register' => 'نام',
        'email_register' => 'ایمیل',
        'password_register' => 'پسورد',
        'isoCode' => 'کد اختصاری',
        'direction' => 'موقعیت قالب',
        'icon' => 'لوگو',
        'company' => 'نام شرکت',
        'domain' => 'آدرس دامنه',
        'country_id' => 'کشور',
        'tellPhone' => 'شماره تلفن',
        'telephone' => 'شماره تلفن',
        'cellPhone' => 'شماره همراه',
        'cellphone' => 'شماره همراه',
        'nationalNumber' => 'شماره ملی',
        'webservice_id' => 'وب سرویس',
        'language_id' => 'زبان',
        'languages' => 'زبان ها',
        'currencies' => 'ارز ها',
        'bank_name' => 'نام بانک',
        'shaba_number' => 'شماره شبا',
        'account_number' => 'شماره حساب',
        'branch_code' => 'کد شعبه',
        'charge_amount' => 'مقدار شارژ',
        'markup_amount' => 'مقدار روکشی',
        'markup_type' => 'نوع روکشی',
        'profile_photo' => 'تصویر پروفایل',
        'old_password'=>'رمز عبور فعلی',
        'new_password'=>'رمز عبور جدید',
        'old_email'=>'ایمیل فعلی',
        'new_email'=>'ایمیل جدید',
        'fromCityFlight'=>'مبدا',
        'toCityFlight'=>'مقصد',
        'fromDateFlight'=>'تاریخ رفت',
        'toDateFlight'=>'تاریخ برگشت',
        'adults'=>'بزرگسال',
        'message'=>'پیام',
        'g-recaptcha-response'=>'کپچا',
        'logo' => 'لوگو',
        'firstname_latin.*'=>'نام لاتین',
        'lastname_latin.*'=>'نام خانوادگی لاتین',
        'firstname_farsi.*'=>'نام',
        'lastname_farsi.*'=>'نام خانوادگی',
        'national_code.*'=>'کد ملی',
        'sex.*'=>'جنسیت',
        'birthday_adults.*'=>'تاریخ تولد',
        'birthday_children.*'=>'تاریخ تولد',
        'birthday_baby.*'=>'تاریخ تولد',
        'rules'=>'قوانین',
        'Service'=>'زبان',
        'permission_id'=>'سطح دسترسی',
        'start_in'=>'تاریخ شروع',
        'origin'=>'مبدا',
        'number_nights'=>'تعداد شب',
        'cities'=>'شهرها',
        'vehicle_type'=>'نوع وسیله نقلیه',
        'documents'=>'مدارک مورد نیاز',
        'destination' => 'مقصد',
    ],
    'currency_sign' => '﷼',

];

