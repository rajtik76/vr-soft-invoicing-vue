export function useConfirmDialog() {

    function confirmDialog(): boolean {
        return confirm('Are you sure ?')
    }

    return { confirmDialog }
}
