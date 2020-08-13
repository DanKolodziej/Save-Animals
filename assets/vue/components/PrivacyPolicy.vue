<template>
    <div class="privacy-policy-page">
        <h1 class="privacy-policy-page__title">
            Polityka prywatności
        </h1>
        <h2 class="privacy-policy-page__header">
            Jakie dane są zbierane
        </h2>
        <p class="privacy-policy-page__paragraph">
            Informujemy, że możemy przetwarzać następujące dane osobowe:
        </p>
        <ul class="privacy-policy-page__list">
            <li>
                Adres poczty elektronicznej
            </li>
            <li>
                Imię
            </li>
            <li>
                Nazwisko
            </li>
            <li>
                Nazwa schroniska (lub innej organizacji)
            </li>
            <li>
                Województwo oraz miejscowość zamieszkania
            </li>
            <li>
                Kontakt (adres poczty elektronicznej, numer telefonu, link do wybranego profilu społecznościowego, strona internetowa itd.)
            </li>
        </ul>
        <p class="privacy-policy-page__paragraph">
            Twoje dane osobowe mogą pochodzić z wypełnionych formularzy na stronie pomoczwierzakom.pl
        </p>
        <h2 class="privacy-policy-page__header">
            Cel zbierania danych osobowych
        </h2>
        <p class="privacy-policy-page__paragraph">
            Podanie danych osobowych jest dobrowolne. Nie ma ustawowego obowiązku podawania danych osobowych, jednak
            niepodanie danych osobowych może skutkować brakiem dostępu do pełnego zakresu funkcjonalności strony pomoczwierzakom.pl
        </p>
        <p class="privacy-policy-page__paragraph">
            Cel zbierania danych: utrzymanie i wsparcie techniczne usługi w zakresie niezbędnym do prawidłowego korzystania z serwisu,
            w szczególności tworzenia i utrzymania kont zarejestrowanych użytkowników.
        </p>
        <p class="privacy-policy-page__paragraph">
            Podstawa prawna: niezbędność do wykonania umowy, której stroną jest użytkownik
            (art. 6 ust. 1 lit b RODO)
        </p>
        <p class="privacy-policy-page__paragraph">
            Okres przetwarzania danych: do momentu zamknięcia serwisu pomoczwierzakom.pl
            (wyjątkiem jest zmiana domeny strony internetowej),
            do momentu pozytywnego rozpatrzenia przez Administratora zażądania usunięcia swoich danych osobowych,
            do momentu samodzielnego usunięcia konta użytkownika.
        </p>
        <h2 class="privacy-policy-page__header">
            Twoje prawa związane z przetwarzaniem danych osobowych
        </h2>
        <p class="privacy-policy-page__paragraph">
            Masz prawo do:
        </p>
        <ul class="privacy-policy-page__list">
            <li>
                Żądania od Administratora dostępu do swoich danych osobowych
            </li>
            <li>
                Żądania od Administratora sprostowania swoich danych osobowych
            </li>
            <li>
                Żądania od Administratora usunięcia lub ograniczenia przetwarzania swoich danych osobowych
            </li>
            <li>
                Wniesienia skargi do organu nadzorczego
            </li>
            <li>
                Cofnięcia zgody na przetwarzanie swoich danych osobowych
            </li>
        </ul>
        <p class="privacy-policy-page__paragraph">
            Po skutecznym wniesieniu prawa do sprzeciwu dane nie będą przetwarzane
            o ile nie będzie istnieć ważna prawnie uzasadniona podstawa do przetwarzania,
            nadrzędna wobec interesów, praw i wolności lub podstawa do ustalenia, dochodzenia lub obrony roszczeń.
        </p>
        <p class="privacy-policy-page__paragraph">
            W celu skorzystania z powyższych praw należy skontaktować się z administratorem (dane znajdują się niżej)
        </p>
        <h2 class="privacy-policy-page__header">
            Administrator danych osobowych
        </h2>
        <p class="privacy-policy-page__paragraph">
            Administratorem twoich danych osobowych jest Daniel Kołodziej, ul. Osiedlowa 36, 56-100 Wołów
        </p>
        <p class="privacy-policy-page__paragraph">
            Z Administratorem można się kontaktować za pomocą poczty elektronicznej, na adres: pomoc.zwierzakom.kontakt@gmail.com
        </p>
        <p class="privacy-policy-page__paragraph">
            Administrator nie wyznaczył Inspektora Ochrony Danych.
        </p>
        <h2 class="privacy-policy-page__header">
            Pozostałe informacje
        </h2>
        <p class="privacy-policy-page__paragraph">
            Organ, do którego można zgłosić swój sprzeciw: Urząd Ochrony Danych Osobowych
        </p>
    </div>
</template>

<script>
    export default {
        name: "PrivacyPolicy"
    }
</script>

<style lang="scss" scoped>

    .privacy-policy-page {

        &__title, &__header {
            text-align: center;
            padding: 0 5%;
        }

        &__header {
            color: #0057E8;
        }

        &__paragraph {
            padding: 0 5%;
        }

        &__list {
            list-style-position: inside;
            padding: 0 5%;
        }
    }

</style>