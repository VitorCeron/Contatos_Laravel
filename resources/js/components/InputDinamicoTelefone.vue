<template>
    <div>
        <div v-for="(line, index) in lines" :key="index" class="row">
            <div class="col-md-12">
                <div class="form-row align-items-center">
                    <input type="hidden" name="id_telefone[]" :value="line.id">
                    <div class="form-group col-md-5">
                        <label for="tipo_telefone">Tipo Telefone</label>
                        <select class="form-control" id="tipo_telefone" name="tipo_telefone[]">
                        <option v-if="line.tipo_telefone != null">{{line.tipo_telefone}}</option>
                        <option value="">Selecione uma opção</option>
                        <option>Residencial</option>
                        <option>Comercial</option>
                        <option>Celular</option>
                        </select>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="telefone">Telefone</label>
                        <input v-if="line.telefone != null" type="text" class="form-control" id="telefone" name="telefone[]" placeholder="Telefone" v-mask="['(##) ####-####', '(##) #####-####']" :value="line.telefone">
                        <input v-else type="text" class="form-control" id="telefone" name="telefone[]" placeholder="Telefone" v-mask="['(##) ####-####', '(##) #####-####']" >
                    </div>

                    <div class="form-group form-inline col-md-2 align-self-end">
                        <button v-if="index + 1 === lines.length" @click="addLine" type="button" id="btnAdicionarRowTelefone" class="btn btn-primary btn-block" ><i class="fas fa-plus"></i> Adicionar</button>
                        <a v-if="index + 1 !== lines.length" @click="removeLine(index)" class="btn btn-danger text-white btn-block"><i class="fas fa-minus"></i> Remover</a>
                    </div>
                </div>
            </div>
        </div>
        <small class="text-muted">Caso nos telefones os campos não sejam preenchidos corretamente, o contato é salvo sem o telefone incorreto.</small>
    </div>
</template>

<script>
    export default {
        data (items) {
            let line = [];
            if(items.items.length != 0){
                line = items.items
            }
            return {
                lines: line,
                blockRemoval: true
            }
        },
        watch: {
            lines () {
                this.blockRemoval = this.lines.length <= 1
            }
        },
        methods: {
            addLine () {
                let checkEmptyLines = this.lines.filter(line => line.number === null)

                if (checkEmptyLines.length >= 1 && this.lines.length > 0) return

                this.lines.push({
                    tipo_telefone: null,
                    telefone: null
                })
            },

            removeLine (lineId) {
                if (!this.blockRemoval) this.lines.splice(lineId, 1)
            }
        },
        props: {
            items: {
                type: Array,
                default: function () { return [] },
            }
        },
        mounted () {
            this.addLine()
        }
    }
</script>

