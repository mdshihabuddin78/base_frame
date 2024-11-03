<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div class="main_component">
        <div class="row">
            <div class="col">
                <data-table :table-heading="tableHeading" table-title="User List" :default-object="{role_id:''}">
                    <template v-slot:page_top>
                        <page-top topPageTitle="User List" page-modal-title="User Add/Edit" :default-object="{numbers:[]}"></page-top>
                    </template>
                    <template v-slot:header>
                        <button @click="openModal('formModal')" class="btn btn-outline-secondary">
                            <i class="fa fa-print"></i> Print
                        </button>
                    </template>
                    <template v-slot:filter>
                        <div class="col-md-2">
                            <select class="form-control" v-model="formFilter.role_id">
                                <option value="">Select</option>
                                <template v-for="(data, index) in requiredData.role">
                                    <option :value="data.id">{{ data.display_name }}</option>
                                </template>
                            </select>
                        </div>
                    </template>
                    <template v-slot:data>
                        <tr v-for="(data, index) in dataList.data">
                            <td class="fw-medium">{{parseInt(dataList.from)+index}}</td>
                            <td>{{data.name}}</td>
                            <td>{{data.email}}</td>
                            <td>{{showData(data.roles, 'display_name')}}</td>
                            <td>{{data.created_at}}</td>
                            <td>
                                <a @click="changeStatus(data)" v-html="showStatus(data.status)"></a>
                            </td>
                            <td>
                                <div class="hstack gap-3 fs-15">
                                    <router-link :to="'/admin/users_details/'+data.id" title="User Details"><i class="fa fa-eye" aria-hidden="true"></i></router-link>
                                    <a class="link-primary" @click="editData(data,data.id)"><i class="fa fa-edit"></i></a>
                                    <a class="link-danger" @click="deleteInformation(data,data.id)"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    </template>
                </data-table>
            </div>
        </div>
        <user-form></user-form>
        <general-modal modal-id="detailsModal" modal-size="modal-md">
            <template v-slot:title v-for="(data, index) in details">
                <span>Details Information of {{data.name}}</span>
            </template>
            <template v-slot:body>
                <div class="row mb-3" id="printDiv">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="container text-center">
                                    <img :src="getImage(null, 'backend_assets/images/User-avatar.svg.png')" style="height: 120px;width: 120px">
                                    <template v-for="(data, index) in details">
                                        <table class="mx-auto" style="width: 80%; text-align: left;">
                                            <tbody>
                                            <tr>
                                                <th class="col-md-5">Name</th>
                                                <th class="col-md-1">:</th>
                                                <td class="col-md-6"> {{data.name}}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-5">NID</th>
                                                <th class="col-md-1">:</th>
                                                <td class="col-md-6"> {{data.nid}}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-5">Company Name</th>
                                                <th class="col-md-1">:</th>
                                                <td class="col-md-6"> {{data.company_name}}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-5">Contact Number</th>
                                                <th class="col-md-1">:</th>
                                                <td class="col-md-6"> {{data.contact_number}}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-5">Company Address</th>
                                                <th class="col-md-1">:</th>
                                                <td class="col-md-6"> {{data.address}}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-5">User Name</th>
                                                <th class="col-md-1">:</th>
                                                <td class="col-md-6"> {{data.username}}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-5">Email</th>
                                                <th class="col-md-1">:</th>
                                                <td class="col-md-6"> {{data.email}}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-5">Masking rate</th>
                                                <th class="col-md-1">:</th>
                                                <td class="col-md-6"> {{data.masking_rate}}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-5">Non Masking rate</th>
                                                <th class="col-md-1">:</th>
                                                <td class="col-md-6"> {{data.non_masking_rate}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </general-modal>
    </div>
</template>

<script>
    import UserForm from "./userForm";
    import DataTable from "../../components/dataTable";
    import Pagination from "../../plugins/pagination/pagination";
    import PageTop from "../../components/pageTop";
    import GeneralModal from "../../components/generalModal";
    export default {
        name: "userList",
        components: {GeneralModal, PageTop, Pagination, DataTable, UserForm},
        data() {
            return {
                tableHeading: ['Sl','Name','Email','Role','Create Date','Status', 'Action'],
                details : ''
            }
        },
        methods : {
            userDetails: function (data) {
                const _this = this;
                var URL = `${_this.urlGenerate()}/${data.id}`;
                _this.getData(URL, "get", {}, {}, function (retData) {
                    _this.details = retData.data;
                    _this.openModal('detailsModal', false);
                });
            },
        },
        mounted(){
            this.getDataList();
        }
    }
</script>

<style scoped>

</style>
