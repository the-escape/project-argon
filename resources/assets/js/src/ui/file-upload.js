import * as FilePond from 'filepond'
import FilePondPluginImagePreview from 'filepond-plugin-image-preview'

export function fileUpload () {
    const el = document.querySelector('.js-file-pond')
    const token = document.querySelector('meta[name=csrf-token]')

    if(!el && !token)
    {
        return
    }

    FilePond.registerPlugin(
        FilePondPluginImagePreview,
    );

    FilePond.setOptions({
        server: {
            url: '/admin/users/upload-profile-image',
            process: {
                headers: {
                    'X-CSRF-TOKEN': token.content
                }
            }
        }
    });

    const pond = FilePond.create(el)
}
