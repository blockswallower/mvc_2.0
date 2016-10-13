<!DOCTYPE html>
<html lang="nl">
    <head>
        <title>my new website</title>
    </head>
    <body>
        {{ for %number to %number2 }}
            <p>test</p>
        {{ end }}

        {{ for 0 to 5 }}
            <p>test2</p>
        {{ end }}

        {{ print %number }}

        {{ if 3 less 4 }}
            <h1>3 is less then 4!</h1>
        {{ end }}

        {{ if 34 greater 12}}
            <p>{{ title }}</p>
        {{ end }}

        {{ if 3 equals 3}}
            <p>3 equals 3!</p>
        {{ end }}

        {{ if 4 !equals 3 }}
            <h1>4 does not equal 3</h1>
        {{ end }}

        {{ if %number equals %number }}
            <h3>We can also use globals</h3>
        {{ end }}

        <p>{{ page_content }}</p>

        <h3>{{ description }}</h3>

        <h1>{{ footer }}</h1>
    </body>
</html>
