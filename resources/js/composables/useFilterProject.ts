import { router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import { watch, type Ref } from 'vue';

export function useFilterSync(filters: Ref<any>[], callback: () => void, delay = 300) {
    const debouncedCallback = debounce(callback, delay);
    filters.forEach((ref) => watch(ref, () => debouncedCallback()));
}

export function useFilterHandler(routeName: string) {
    return debounce((params: Record<string, any>) => {
        const filteredParams = Object.fromEntries(Object.entries(params).filter(([, v]) => v !== '' && v !== null && v !== undefined));

        router.get(route(routeName), filteredParams, {
            preserveState: true,
            replace: true,
            preserveScroll: true,
            onError: (errors) => console.error(errors),
        });
    }, 300);
}
