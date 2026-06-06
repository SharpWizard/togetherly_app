<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 유효성 검사 언어 줄 (Validation Language Lines)
    |--------------------------------------------------------------------------
    |
    | 아래 언어 줄은 유효성 검사기 클래스가 사용하는 기본 오류 메시지입니다.
    | 일부 규칙은 size 규칙처럼 여러 버전을 가집니다. 필요에 따라 자유롭게
    | 메시지를 수정하세요.
    |
    */

    'accepted' => ':attribute을(를) 동의해야 합니다.',
    'accepted_if' => ':other이(가) :value일 때 :attribute을(를) 동의해야 합니다.',
    'active_url' => ':attribute은(는) 유효한 URL이 아닙니다.',
    'after' => ':attribute은(는) :date 이후의 날짜여야 합니다.',
    'after_or_equal' => ':attribute은(는) :date 이후이거나 같은 날짜여야 합니다.',
    'alpha' => ':attribute은(는) 문자만 포함할 수 있습니다.',
    'alpha_dash' => ':attribute은(는) 문자, 숫자, 대시(-), 밑줄(_)만 포함할 수 있습니다.',
    'alpha_num' => ':attribute은(는) 문자와 숫자만 포함할 수 있습니다.',
    'array' => ':attribute은(는) 배열이어야 합니다.',
    'ascii' => ':attribute은(는) 1바이트 영숫자와 기호만 포함할 수 있습니다.',
    'before' => ':attribute은(는) :date 이전의 날짜여야 합니다.',
    'before_or_equal' => ':attribute은(는) :date 이전이거나 같은 날짜여야 합니다.',
    'between' => [
        'array' => ':attribute은(는) :min개에서 :max개 사이의 항목이어야 합니다.',
        'file' => ':attribute은(는) :min KB에서 :max KB 사이여야 합니다.',
        'numeric' => ':attribute은(는) :min에서 :max 사이여야 합니다.',
        'string' => ':attribute은(는) :min자에서 :max자 사이여야 합니다.',
    ],
    'boolean' => ':attribute은(는) 참 또는 거짓이어야 합니다.',
    'confirmed' => ':attribute 확인이 일치하지 않습니다.',
    'current_password' => '비밀번호가 올바르지 않습니다.',
    'date' => ':attribute은(는) 유효한 날짜가 아닙니다.',
    'date_equals' => ':attribute은(는) :date와(과) 같은 날짜여야 합니다.',
    'date_format' => ':attribute은(는) :format 형식과 일치하지 않습니다.',
    'decimal' => ':attribute은(는) 소수점 :decimal자리여야 합니다.',
    'declined' => ':attribute을(를) 거부해야 합니다.',
    'declined_if' => ':other이(가) :value일 때 :attribute을(를) 거부해야 합니다.',
    'different' => ':attribute와(과) :other은(는) 서로 달라야 합니다.',
    'digits' => ':attribute은(는) :digits자리 숫자여야 합니다.',
    'digits_between' => ':attribute은(는) :min자리에서 :max자리 사이의 숫자여야 합니다.',
    'dimensions' => ':attribute의 이미지 크기가 올바르지 않습니다.',
    'distinct' => ':attribute에 중복된 값이 있습니다.',
    'doesnt_end_with' => ':attribute은(는) 다음으로 끝날 수 없습니다: :values.',
    'doesnt_start_with' => ':attribute은(는) 다음으로 시작할 수 없습니다: :values.',
    'email' => ':attribute은(는) 유효한 이메일 주소여야 합니다.',
    'ends_with' => ':attribute은(는) 다음 중 하나로 끝나야 합니다: :values.',
    'enum' => '선택한 :attribute이(가) 올바르지 않습니다.',
    'exists' => '선택한 :attribute이(가) 올바르지 않습니다.',
    'file' => ':attribute은(는) 파일이어야 합니다.',
    'filled' => ':attribute에는 값이 있어야 합니다.',
    'gt' => [
        'array' => ':attribute은(는) :value개보다 많은 항목이어야 합니다.',
        'file' => ':attribute은(는) :value KB보다 커야 합니다.',
        'numeric' => ':attribute은(는) :value보다 커야 합니다.',
        'string' => ':attribute은(는) :value자보다 길어야 합니다.',
    ],
    'gte' => [
        'array' => ':attribute은(는) :value개 이상의 항목이어야 합니다.',
        'file' => ':attribute은(는) :value KB 이상이어야 합니다.',
        'numeric' => ':attribute은(는) :value 이상이어야 합니다.',
        'string' => ':attribute은(는) :value자 이상이어야 합니다.',
    ],
    'image' => ':attribute은(는) 이미지여야 합니다.',
    'in' => '선택한 :attribute이(가) 올바르지 않습니다.',
    'in_array' => ':attribute이(가) :other에 존재하지 않습니다.',
    'integer' => ':attribute은(는) 정수여야 합니다.',
    'ip' => ':attribute은(는) 유효한 IP 주소여야 합니다.',
    'ipv4' => ':attribute은(는) 유효한 IPv4 주소여야 합니다.',
    'ipv6' => ':attribute은(는) 유효한 IPv6 주소여야 합니다.',
    'json' => ':attribute은(는) 유효한 JSON 문자열이어야 합니다.',
    'lowercase' => ':attribute은(는) 소문자여야 합니다.',
    'lt' => [
        'array' => ':attribute은(는) :value개보다 적은 항목이어야 합니다.',
        'file' => ':attribute은(는) :value KB보다 작아야 합니다.',
        'numeric' => ':attribute은(는) :value보다 작아야 합니다.',
        'string' => ':attribute은(는) :value자보다 짧아야 합니다.',
    ],
    'lte' => [
        'array' => ':attribute은(는) :value개를 초과할 수 없습니다.',
        'file' => ':attribute은(는) :value KB 이하여야 합니다.',
        'numeric' => ':attribute은(는) :value 이하여야 합니다.',
        'string' => ':attribute은(는) :value자 이하여야 합니다.',
    ],
    'mac_address' => ':attribute은(는) 유효한 MAC 주소여야 합니다.',
    'max' => [
        'array' => ':attribute은(는) :max개를 초과할 수 없습니다.',
        'file' => ':attribute은(는) :max KB를 초과할 수 없습니다.',
        'numeric' => ':attribute은(는) :max을(를) 초과할 수 없습니다.',
        'string' => ':attribute은(는) :max자를 초과할 수 없습니다.',
    ],
    'max_digits' => ':attribute은(는) :max자리를 초과할 수 없습니다.',
    'mimes' => ':attribute은(는) 다음 형식의 파일이어야 합니다: :values.',
    'mimetypes' => ':attribute은(는) 다음 형식의 파일이어야 합니다: :values.',
    'min' => [
        'array' => ':attribute은(는) 최소 :min개의 항목이어야 합니다.',
        'file' => ':attribute은(는) 최소 :min KB여야 합니다.',
        'numeric' => ':attribute은(는) 최소 :min이어야 합니다.',
        'string' => ':attribute은(는) 최소 :min자여야 합니다.',
    ],
    'min_digits' => ':attribute은(는) 최소 :min자리여야 합니다.',
    'missing' => ':attribute 필드는 없어야 합니다.',
    'missing_if' => ':other이(가) :value일 때 :attribute 필드는 없어야 합니다.',
    'missing_unless' => ':other이(가) :value이(가) 아니면 :attribute 필드는 없어야 합니다.',
    'missing_with' => ':values이(가) 있을 때 :attribute 필드는 없어야 합니다.',
    'missing_with_all' => ':values이(가) 모두 있을 때 :attribute 필드는 없어야 합니다.',
    'multiple_of' => ':attribute은(는) :value의 배수여야 합니다.',
    'not_in' => '선택한 :attribute이(가) 올바르지 않습니다.',
    'not_regex' => ':attribute 형식이 올바르지 않습니다.',
    'numeric' => ':attribute은(는) 숫자여야 합니다.',
    'password' => [
        'letters' => ':attribute은(는) 최소 하나의 문자를 포함해야 합니다.',
        'mixed' => ':attribute은(는) 대문자와 소문자를 각각 최소 하나씩 포함해야 합니다.',
        'numbers' => ':attribute은(는) 최소 하나의 숫자를 포함해야 합니다.',
        'symbols' => ':attribute은(는) 최소 하나의 기호를 포함해야 합니다.',
        'uncompromised' => '입력한 :attribute이(가) 데이터 유출에 노출된 적이 있습니다. 다른 :attribute을(를) 선택하세요.',
    ],
    'present' => ':attribute 필드가 있어야 합니다.',
    'prohibited' => ':attribute 필드는 금지되어 있습니다.',
    'prohibited_if' => ':other이(가) :value일 때 :attribute 필드는 금지됩니다.',
    'prohibited_unless' => ':other이(가) :values에 없으면 :attribute 필드는 금지됩니다.',
    'prohibits' => ':attribute 필드가 있으면 :other을(를) 사용할 수 없습니다.',
    'regex' => ':attribute 형식이 올바르지 않습니다.',
    'required' => ':attribute은(는) 필수 항목입니다.',
    'required_array_keys' => ':attribute 필드는 다음 항목을 포함해야 합니다: :values.',
    'required_if' => ':other이(가) :value일 때 :attribute은(는) 필수 항목입니다.',
    'required_if_accepted' => ':other이(가) 동의되었을 때 :attribute은(는) 필수 항목입니다.',
    'required_unless' => ':other이(가) :values에 없으면 :attribute은(는) 필수 항목입니다.',
    'required_with' => ':values이(가) 있을 때 :attribute은(는) 필수 항목입니다.',
    'required_with_all' => ':values이(가) 모두 있을 때 :attribute은(는) 필수 항목입니다.',
    'required_without' => ':values이(가) 없을 때 :attribute은(는) 필수 항목입니다.',
    'required_without_all' => ':values이(가) 하나도 없을 때 :attribute은(는) 필수 항목입니다.',
    'same' => ':attribute와(과) :other은(는) 일치해야 합니다.',
    'size' => [
        'array' => ':attribute은(는) :size개의 항목을 포함해야 합니다.',
        'file' => ':attribute은(는) :size KB여야 합니다.',
        'numeric' => ':attribute은(는) :size여야 합니다.',
        'string' => ':attribute은(는) :size자여야 합니다.',
    ],
    'starts_with' => ':attribute은(는) 다음 중 하나로 시작해야 합니다: :values.',
    'string' => ':attribute은(는) 문자열이어야 합니다.',
    'timezone' => ':attribute은(는) 유효한 시간대여야 합니다.',
    'unique' => ':attribute은(는) 이미 사용 중입니다.',
    'uploaded' => ':attribute 업로드에 실패했습니다.',
    'uppercase' => ':attribute은(는) 대문자여야 합니다.',
    'url' => ':attribute은(는) 유효한 URL이어야 합니다.',
    'ulid' => ':attribute은(는) 유효한 ULID여야 합니다.',
    'uuid' => ':attribute은(는) 유효한 UUID여야 합니다.',

    /*
    |--------------------------------------------------------------------------
    | 사용자 지정 유효성 검사 언어 줄
    |--------------------------------------------------------------------------
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | 사용자 지정 유효성 검사 속성명
    |--------------------------------------------------------------------------
    |
    | 아래 언어 줄은 ":attribute" 자리표시자를 "email" 대신 "이메일 주소"처럼
    | 더 읽기 쉬운 표현으로 바꾸는 데 사용됩니다.
    |
    */

    'attributes' => [
        'name' => '이름',
        'email' => '이메일 주소',
        'password' => '비밀번호',
        'password_confirmation' => '비밀번호 확인',
        'phone' => '전화번호',
        'neighborhood' => '동네',
        'bio' => '소개',
        'avatar' => '프로필 사진',
        'title' => '제목',
        'description' => '설명',
        'food_type' => '음식 종류',
        'quantity' => '수량',
        'expires_at' => '이용 가능 기한',
        'status' => '상태',
        'image' => '사진',
        'category' => '카테고리',
        'skill_level' => '기술 수준',
        'available_times' => '가능한 시간',
        'message' => '메시지',
        'preferred_time' => '원하는 시간',
        'rating' => '평점',
        'comment' => '코멘트',
        'reason' => '사유',
        'details' => '상세 내용',
        'account_type' => '계정 유형',
    ],

];
