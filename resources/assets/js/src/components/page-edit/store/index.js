import Vuex from "vuex";
import { blockSelect, fields, page } from "./modules";

export function getStore() {
    return new Vuex.Store({
        modules: {
            blockSelect,
            fields,
            page
        }
    });
}
