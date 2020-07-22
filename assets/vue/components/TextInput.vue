<template>
    <label class="input-label">
        {{ label }}
        <input class="text-input"
               :class="{'text-input--error': error.length > 0}"
               v-model="value"
               :placeholder="error"
               @input="onInputChange"
               @click="onClick"
               type="text"
        >
    </label>
</template>

<script>
    export default {
        name: "TextInput",
        props: {
            label: {
                type: String,
                required: true
            },
            error: {
                type: String,
                required: false
            }
        },
        data() {
            return {
                value: ''
            }
        },
        watch: {
            error: function () {
                if(this.error.length > 0) {
                    this.value = '';
                }
            }
        },
        methods: {
            onInputChange: function() {
                this.$emit('updateValue', this.value);
            },
            onClick: function() {
                this.$emit('deleteErrorMessage');
            }
        }
    }
</script>

<style lang="scss" scoped>

    .input-label {
        color: #fff;
        font-weight: bold;
    }

    .text-input {
        display: block;
        width: 100%;
        margin: 5px 0 10px;
        padding: 5px;
        font-size: 18px;
        border: 2px solid #00A8E8;
        border-radius: 3px;
        box-sizing: border-box;
        box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.75);

        &:focus {
            outline: none;
            box-shadow: 0 0 5px 0 #00dce8;
        }

        &--error {
            border-color: #C82829;
            background-color: #eeaaaa;
            color: #C82829;

            &:focus {
                box-shadow: 0 0 5px 0 #eeaaaa;
            }

            &::placeholder {
                    color: #C82829;
                }
        }
    }

</style>