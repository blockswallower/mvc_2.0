{{ @extend layout/header }}
        {{ for %number to %number2 }}
            <h1>test</h1>
        {{ end }}

        {{ for 0 to 5 }}
            <h1>test2</h1>
        {{ end }}

        {{ if 3 less 4 }}
            <h1>3 is less then 4!</h1>
        {{ end }}

        {{ if 34 greater 12}}
            <h1>{{ title }}</h1>
        {{ end }}

        {{ if 3 equals 3}}
            <h1>3 equals 3!</h1>
        {{ end }}

        {{ if 4 !equals 3 }}
            <h1>4 does not equal 3</h1>
        {{ end }}

        {{ if %number equals %number }}
            <h1>We can also use globals</h1>
        {{ end }}

        <h1>{{ page_content }}</h1>

        <h1>{{ description }}</h1>

        <h1>{{ footer }}</h1>
{{ @extend layout/footer }}
