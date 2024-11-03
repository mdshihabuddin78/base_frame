<template>
    <form-modal @submit="submitForm(formObject,'formModal')" modal-id="formModal" modal-size="modal-xs" back-drop="static">
        <div class="mb-2">
            <div class="row">
                <div class="col-md-4">
                    <label class="col-form-label">User Role </label>
                </div>
                <div class="col-md-8">
                    <select class="form-control" v-model="formObject.role_id">
                        <option value="">---Select Role---</option>
                        <template v-for="(data, index) in requiredData.role">
                            <option :value="data.id">{{ data.display_name }}</option>
                        </template>
                    </select>
                </div>
            </div>
        </div>
        <div class="mb-2">
            <div class="row">
                <div class="col-md-4">
                    <label class="col-form-label">Name </label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" v-validate="'required'" v-model="formObject.name" placeholder="Type your Name" name="name">
                </div>
            </div>
        </div>
        <div class="mb-2">
            <div class="row">
                <div class="col-md-4">
                    <label class="col-form-label">NID No. </label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" v-validate="'required'" v-model="formObject.nid" placeholder="Enter Your Valid NID" name="nid">
                </div>
            </div>
        </div>
        <div class="mb-2">
            <div class="row">
                <div class="col-md-4">
                    <label class="col-form-label">Company Name </label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" v-validate="'required'" v-model="formObject.company_name" placeholder="Enter your Company Name" name="company_name">
                </div>
            </div>
        </div>
        <div class="mb-2">
            <div class="row">
                <div class="col-md-4">
                    <label class="col-form-label">Company Address </label>
                </div>
                <div class="col-md-8">
                    <textarea type="text" class="form-control" v-validate="'required'" v-model="formObject.address" placeholder="Enter Company Address" name="address" rows="2"></textarea>
                </div>
            </div>
        </div>
        <div class="mb-2">
            <div class="row">
                <div class="col-md-4">
                    <label class="col-form-label">Contact Number</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" v-validate="'required'" v-model="formObject.contact_number" placeholder="Type your Contact Pone Number" name="phone_number">
                </div>
            </div>
        </div>
        <hr>
        <div class="mb-2">
            <div class="row">
                <div class="col-md-4">
                    <label class="col-form-label">User Name </label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" v-validate="'required'" v-model="formObject.username" placeholder="Only receive small letter and no special character" name="user_name">
                </div>
            </div>
        </div>
        <div class="mb-2"  v-if="formType === 1">
            <div class="row">
                <div class="col-md-4">
                    <label class="col-form-label">Login Email Address </label>
                </div>
                <div class="col-md-8">
                    <input type="email" class="form-control" v-validate="'required'" v-model="formObject.email" placeholder="Enter Valid Email" name="email">
                </div>
            </div>
        </div>
        <div class="mb-2" v-if="formType === 1">
            <div class="row">
                <div class="col-md-4">
                    <label class="col-form-label">Password </label>
                </div>
                <div class="col-md-8">
                    <input type="password" class="form-control" v-validate="'required'" v-model="formObject.password" placeholder="Enter Strong Password" name="password">
                </div>
            </div>
        </div>
        <hr>
        <div class="mb-2">
            <div class="row">
                <div class="col-md-4">
                    <label class="col-form-label">Is Super Admin </label>
                </div>
                <div class="col-md-8">
                    <div class="form-check col-md-2">
                        <label for="yes" class="form-check-label" style="margin-top: 8px;">Yes</label>
                        <input type="checkbox" class="form-check-input" id="yes" name="check_role" :value="1" v-model="formObject.is_superadmin" style="margin-top: 10px; font-size: 14px;">
                    </div>
                </div>
            </div>
        </div>
    </form-modal>
</template>

<script>
    import FormModal from "../../components/formModal";
    export default {
        name: "userForm",
        components: {FormModal},
        data() {
            return{

            }
        },
        mounted() {
            this.getGeneralData(['role']);
            this.$set(this.formObject, 'role_id', '');
        }
    }
</script>

<style scoped>

</style>
