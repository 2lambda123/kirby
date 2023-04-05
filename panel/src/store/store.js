import Vue from "vue";
import Vuex from "vuex";

// store modules
import content from "./modules/content.js";
import drawers from "./modules/drawers.js";
import notification from "./modules/notification.js";

Vue.use(Vuex);

export default new Vuex.Store({
	// eslint-disable-next-line
	strict: process.env.NODE_ENV !== "production",
	state: {
		dialog: null,
		drag: null,
		isLoading: false
	},
	mutations: {
		SET_DIALOG(state, dialog) {
			state.dialog = dialog;
		},
		SET_DRAG(state, drag) {
			state.drag = drag;
		},
		SET_LOADING(state, loading) {
			state.isLoading = loading;
		}
	},
	actions: {
		dialog(context, dialog) {
			context.commit("SET_DIALOG", dialog);
		},
		drag(context, drag) {
			context.commit("SET_DRAG", drag);
		},
		/**
		 * @deprecated Use window.panel.notification.fatal()
		 */
		fatal(context, options) {
			window.panel.notification.fatal(options);
		},
		isLoading(context, loading) {
			context.commit("SET_LOADING", loading === true);
		},
		navigate(context) {
			context.dispatch("dialog", null);
			context.dispatch("drawers/close");
		}
	},
	modules: {
		content: content,
		drawers: drawers,
		notification: notification
	}
});
