<template>
    <div id="layout-wrapper">
        <top-nav-bar></top-nav-bar>
        <side-nav-bar></side-nav-bar>
        <div class="vertical-overlay"></div>
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <router-view></router-view>
                </div>
            </div>
            <prfooter></prfooter>
        </div>
    </div>
</template>

<script>
    import TopNavBar from "./topNavBar";
    import SideNavBar from "./sideNavBar";
    import prfooter from "./prfooter";
    export default {
        name: "baseLayouts",
        components: {SideNavBar, TopNavBar,prfooter}
    }
</script>

<style scoped>

</style>
