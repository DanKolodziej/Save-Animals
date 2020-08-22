<template>
    <footer class="footer">
        ©2020 pomoc-zwierzakom.pl
        <a class="footer__link"
           href="/polityka-prywatnosci"
           target="_blank"
        >
            polityka prywatności
        </a>
        <span>
            kontakt:
            <a class="footer__link"
               href="mailto:pomoc.zwierzakom.kontakt@gmail.com"
            >
                pomoc.zwierzakom.kontakt@gmail.com
            </a>
        </span>
    </footer>
</template>

<script>
    export default {
        name: "FooterBar"
    }
</script>

<style lang="scss" scoped>
    .footer {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        height: 90px;
        background-color: #00A8E8;
        color: #fff;
        padding: 15px 0;

        @media (min-width: 768px) {
            flex-direction: row;
            padding: 0 15px;
        }

        &__link {
            display: inline-block;
            color: #fff;
            text-decoration: none;
            transition: all 0.5s ease-out;

            &:after {
                content: '';
                width: 0;
                height: 1px;
                display: block;
                background: #0057E8;
                transition: all 0.5s ease-out;
            }

            &:hover {
                color: #0057E8;
                /*text-decoration: underline;*/

                &:after {
                    width: 100%;
                }
            }
        }
    }
</style>