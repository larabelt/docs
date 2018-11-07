<template>
    <div class="parameters">
        <p><strong>Parameters</strong></p>
        <table>
            <thead>
                <th>Name</th>
                <th>Type</th>
                <th>Default</th>
                <th>Required</th>
            </thead>
            <tbody>
                <tr v-for="item in items">
                    <td>{{ item.name }}</td>
                    <td>{{ item.type }}</td>
                    <td>{{ item.default }}</td>
                    <td>{{ item.required ? 'true' : 'false' }}</td>
                </tr>

                <!-- <tr v-for="(param, index) in params">
                    <td>{{ index }}</td>
                    <td>{{ param.type }}</td>
                    <td>{{ param.default }}</td>
                    <td>{{ param.required ? 'true' : 'false' }}</td>
                </tr> -->
            </tbody>
        </table>
    </div>
</template>

<script>
import _ from 'lodash'

export default {
    props: {
        params: {
            type: Array,
            default: () => {
                return []
            }
        }
    },
    computed: {
        items() {
            let items = []

            this.params.forEach(item => {
                let option = this.optionGet(item)
                if(option) {
                    items.push(option)
                }
            })

            return items
        }
    },
    data() {
        return {
            options: [
                {
                    name: 'perPage',
                    type: '[alphanumeric]',
                    default: 12,
                    required: false
                },
                {
                    name: 'page',
                    type: '[alphanumeric]',
                    default: 1,
                    required: false
                }
            ]
        }
    },
    methods: {
        optionGet(option) {
            /* todo
                Want to create an override
                sytnax perPage|default:15
            */


            let item = _.find(this.options, {name: option})

            return item ? item : null;
        }
    }
}
</script>

