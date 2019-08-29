import Vue from "vue";
import Vuex from "vuex";
import App from "./App.vue";
import draggable from "vuedraggable";
import types from "./types/types.vue";
import { getStore } from "./store";
import { deepClone } from "../../util";
import { addTabInit } from "../../ui/tabs";

Vue.config.productionTip = false;
Vue.component("draggable", draggable);
Vue.component("types", types);
Vue.use(Vuex);

export function Fields() {
    const fieldEls = document.querySelectorAll(".js-fields");
    const fields = Array.from(fieldEls);
    return fields.map(el => {
        // const tabPanel = el.closest('[data-tab]')
        // const tabName = tabPanel.dataset.tab
        const name = el.dataset.name;
        const store = getStore();
        let { fields, header, actions = true } = window.fieldGroups[name];
        store.commit("fields/setupGroup", {
            groupID: name,
            fields,
            header,
            isShowingActions: actions
        });
        return new Vue({
            store,
            render: h => h(App)
        }).$mount(el);
        // addTabInit(tabName, () => {
        // })
    });
}
