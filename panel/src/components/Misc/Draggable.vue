<template>
	<draggable
		v-bind="dragOptions"
		:component-data="data"
		:tag="element"
		:list="list"
		:move="move"
		class="k-draggable"
		v-on="listeners"
	>
		<slot />
		<template #footer>
			<slot name="footer" />
		</template>
	</draggable>
</template>

<script>
/**
 * The Draggable component implements the
 * [Vue.Draggable](https://github.com/SortableJS/Vue.Draggable)
 * library which is a wrapper for the widespread
 * [Sortable.js](https://github.com/RubaXa/Sortable) library.
 *
 * @example
 * <k-draggable>
 *   <li>Drag me.</li>
 *   <li>Or me.</li>
 *   <li>Drop it!</li>
 * </k-draggable>
 */
export default {
	components: {
		draggable: () => import("vuedraggable/src/vuedraggable")
	},
	props: {
		data: Object,
		/**
		 * HTML element for the wrapper
		 */
		element: String,
		/**
		 * Whether to use a sort handle
		 * or, if yes, which CSS selector
		 * can be used
		 */
		handle: [String, Boolean],
		list: [Array, Object],
		move: Function,
		options: Object
	},
	data() {
		return {
			listeners: {
				...this.$listeners,
				start: (event) => {
					this.$store.dispatch("drag", {});

					if (this.$listeners.start) {
						this.$listeners.start(event);
					}
				},
				end: (event) => {
					this.$store.dispatch("drag", null);

					if (this.$listeners.end) {
						this.$listeners.end(event);
					}
				}
			}
		};
	},
	computed: {
		dragOptions() {
			let handle = false;

			if (this.handle === true) {
				handle = ".k-sort-handle";
			} else {
				handle = this.handle;
			}

			return {
				fallbackClass: "k-sortable-fallback",
				fallbackOnBody: true,
				forceFallback: true,
				ghostClass: "k-sortable-ghost",
				handle: handle,
				scroll: document.querySelector(".k-panel-view"),
				...this.options
			};
		}
	}
};
</script>
