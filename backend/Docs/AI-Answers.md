

## نسخه دقیق‌تر نمودار (با همه شرایط)

<div dir="rtl">

```mermaid
flowchart TB
    %% ===== Entry =====
    A[Client Request<br/>POST /api/user/register] --> B[Symfony Kernel + Router]
    B --> C[UserRegistrationController register]

    %% ===== Request parsing =====
    C --> D{JSON قابل Parse است؟}
    D -- خیر --> E[BadRequestHttpException]
    E --> S[UserHttpExceptionSubscriber]
    S --> E400[400 JSON<br/>Invalid JSON payload]

    D -- بله --> F[MapRequestPayload to UserRegistrationDTO]
    F --> G{Validation پاس شد؟}
    G -- خیر --> H[UnprocessableEntityHttpException<br/>+ ValidationFailedException]
    H --> S
    S --> E422[422 JSON<br/>Validation failed + errors]

    %% ===== UseCase flow =====
    G -- بله --> I[Create RegisterUserCommand]
    I --> J[RegisterUserUseCase::execute]
    J --> K[UserRepository findOneByEmail]
    K --> L{Email exists?}

    L -- بله --> M[EmailAlreadyExistsException]
    M --> S
    S --> E409[409 JSON<br/>Email already exists]

    L -- خیر --> N[Create User Entity]
    N --> O[PasswordHasherGateway hash]
    O --> P[DoctrineUserRepository save]
    P --> Q{Save موفق بود؟}

    Q -- بله --> R[RegisterUserResult]
    R --> T[Controller returns JSON 201]
    T --> E201[201 JSON<br/>id, name, email]

    %% ===== Unhandled / system failures =====
    Q -- خیر --> U[Unhandled Exception<br/>DB/Infra Error]
    U --> V[Symfony Default Error Handling]
    V --> E500[500 JSON/HTML<br/>Internal Server Error]

    %% ===== Styling =====
    classDef ok fill:#E8F5E9,stroke:#2E7D32,color:#1B5E20,stroke-width:1.5px;
    classDef warn fill:#FFF8E1,stroke:#F9A825,color:#F57F17,stroke-width:1.5px;
    classDef validation fill:#FFF3E0,stroke:#EF6C00,color:#E65100,stroke-width:1.5px;
    classDef conflict fill:#FFEBEE,stroke:#C62828,color:#B71C1C,stroke-width:1.5px;
    classDef fail fill:#F3E5F5,stroke:#6A1B9A,color:#4A148C,stroke-width:1.5px;
    classDef normal fill:#E3F2FD,stroke:#1565C0,color:#0D47A1,stroke-width:1.2px;

    class A,B,C,F,I,J,K,N,O,P,R,T normal;
    class D,G,L,Q warn;
    class E400,E validation;
    class E422,H validation;
    class E409,M conflict;
    class E201 ok;
    class U,V,E500 fail;
```

### نکات دقت نمودار

- **400** فقط وقتی body از نظر JSON خراب باشد.
- **422** وقتی JSON درست است ولی validation فیلدها رد شود.
- **409** وقتی ایمیل قبلا موجود باشد (قانون دامنه).
- **201** وقتی تمام مراحل موفق باشد.
- **500** برای خطاهای پیش‌بینی‌نشده زیرساخت/سیستمی.

</div>

</div>

</div>

</div>
