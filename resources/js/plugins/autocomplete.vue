<script>
    export default {
        name : 'autocomplete',
        props: {
            maxlength : String,
            minlength : String,
            placeholder : String,
            validate : String,
            value : String,
            name : String,
            readonly:{
              type: Boolean,
              default: false,
            },
            validation_name : String,
            branch: {
                type : [String, Number],
                required: false,
                default: null,
            },
        },

        data() {
            return {
                isOpen: false,
                results: [],
                search: this.value,
                isLoading: false,
                arrowCounter: 0,
                selected:{
                    m_member_name : '',
                    m_spouse_father_son_name : '',
                },
                inputedValue : '',
                spouseField : ['Married','Widower','Widow'],
            }
        },

        methods: {
            onChange() {
                this.$emit('input', this.inputValue);
                this.filterResults();
            },
            filterResults(value, checkLength = true) {
                const _this = this;
                _this.selected = {m_member_name : '',m_spouse_father_son_name : ''};
                _this.results = [];

                _this.isLoading = true;
                var url = _this.urlGenerate('api/search_user');

                if (value !== ''){
                    _this.httpReq(url, 'post', {},{name : value}, function (retData) {
                        _this.isLoading = false;
                        _this.results = retData;
                    });
                }
            },
            setResult(result) {
                this.inputedValue = result.m_member_code;
                this.inputValue = result.m_member_code;
                this.selected = result;
                this.$emit('input', result.m_member_code);
                this.$emit('change');
                this.$emit('update');
                this.$emit('keyup');
                this.$emit('keydown');
                this.results = [];
                this.isOpen = false;
            },
            callKeyUp() {
                this.$emit('keyup');
            },
            onArrowDown(evt) {
                if (this.arrowCounter < this.results.length) {
                    this.arrowCounter = this.arrowCounter + 1;
                }
            },
            onArrowUp() {
                if (this.arrowCounter > 0) {
                    this.arrowCounter = this.arrowCounter -1;
                }
            },
            onEnter(e) {
                this.$emit("input", e.target.value);
                this.value = this.results[this.arrowCounter];
                this.isOpen = false;
                this.arrowCounter = -1;
            },
            updateValue(e) {
                const _this = this;
                _this.inputedValue = e.target.value;
                _this.$emit("input", e.target.value);
                _this.filterResults(e.target.value, true);
            }
        },
        created () {
            this.$validator = this.$parent.$validator
        },
        watch : {
            value : function (newVal, val) {
                if (!this.value){
                    this.selected = {
                        m_member_name : '',
                        m_spouse_father_son_name : '',
                    };
                }
            }
        }
    }
</script>
<template>
    <div class="autocomplete">
        <div class="autocomplete_input row">
             <div class="col-10">
                 <div class="input-group mb-3">
                     <input class="form-control" :value="value" @input="updateValue" @keyup="callKeyUp()" @blur="$emit('blur')" :readonly="readonly" :name="name" :maxlength="maxlength"  autocomplete="off" :data-vv-as="validation_name" :placeholder="placeholder" v-validate="validate" @keydown.down="onArrowDown" @keydown.up="onArrowUp" @keydown.enter="onEnter">
                     <div class="input-group-append">
                         <span class="input-group-text">
                             <i v-if="isLoading" class="fa fa-spinner fa-spin"></i>
                             <i v-else @click="filterResults(inputedValue, false)" class="fa fa-search"></i>
                         </span>
                     </div>
                 </div>
             </div>
        </div>
        <ul id="autocomplete-results" class="autocomplete-results" v-if="results.length > 0">
            <li v-for="(result, index) in results"  @click="setResult(result)" class="autocomplete-result">
                <div class="each_member">
                    <p class="autocpmpletep member_code"><strong>{{result.name}}</strong></p>
                </div>
            </li>
        </ul>
    </div>
</template>

<style scoped>
    ul{
        padding-left: 0 !important;
    }
    p.autocpmpletep {
        margin-bottom: 0 !important;
    }
    .autocomplete{
        position: relative;
    }
    .autocomplete-result {
        background-image: none !important;
    }

    .autocomplete-input {
        background-image: none !important;
    }

    input.autocomplete-input {
        border: 1px solid #ddd !important;
        border-radius: 0 !important;
        background: #FFF !important;
    }

    li.autocomplete-result {
        padding: 0 !important;
        cursor: pointer;
    }

    li.autocomplete-result .each_member {
        padding: 5px;
        margin: 2px 0;
        border: 1px solid #ddd;
        background: #FFF;
    }

    li.autocomplete-result .each_member:hover {
        background: #ddd !important;
    }

    li.autocomplete-result .each_member p {
        font-size: 12px;
    }

    li.autocomplete-result .each_member p strong {
        text-transform: uppercase;
        font-weight: 800;
        padding: 0 !important;
    }

    .each_member .member_code{
        color: #1717c3 !important;
    }

    ul#autocomplete-results::-webkit-scrollbar {
        width: 3px;
        background: #000;
    }

    ul#autocomplete-results::-webkit-scrollbar-track {
        border-radius: 3px;
    }

    ul#autocomplete-results::-webkit-scrollbar-thumb {
        border-radius: 3px;
    }

    .autocomplete_input {
        position: relative;
    }

    ul#autocomplete-results {
        max-height: 219px;
        position: absolute;
        overflow: auto;
        width: 100%;
        top: 29px;
        z-index: 999999999;
    }
    .col-2.auto_button {
        padding-left: 5px;
    }
    .col-10.auto_form{
        padding-right: 0;
    }

    a.autocomplete_search {
        margin-top: 5px;
        cursor: pointer;
    }
    a.autocomplete_search i {
        padding: 5px 5px 6px 5px;
        background: #DDD;
    }
</style>
