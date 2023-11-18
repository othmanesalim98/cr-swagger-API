import AppForm from '../app-components/Form/AppForm';

Vue.component('teest-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                uuid:  '' ,
                connection:  '' ,
                queue:  '' ,
                payload:  '' ,
                exception:  '' ,
                failed_at:  '' ,
                
            }
        }
    }

});