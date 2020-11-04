<script>
export default {
  name: "order",
  data() {
    return {
      city: null,
      country: null,
      firstname: '',
      lastname: '',
      address: '',
      phone: '',
      email: '',
      companies: [],
      stepMin: 0.5, // Мин вес для покупки
      cost: 0,
      items: [],
      company: null
    }
  },
  props: {
    auth: {
      type: Number,
      required: true
    },
    itemsprop: {
      required: true
    }
  },
  mounted () {
    let self = this
    $('#city').select2().on('change', function (e) {
      self.city = this.value
    })
    $('#country').select2().on('change', function (e) {
      self.country = this.value
    })

    if (this.auth) {
      this.items = this.itemsprop
    } else {
      this.items = this.$store.state.cart.items
    }

    this.items.forEach(item => {
      this.cost += item.on_sale ? Number(item.price_sale) : Number(item.price)
    })
  },
  watch: {
    'city': function (after, before) {
      axios.post('/api/companies', {city: this.city})
        .then(response => {
          response.data.length > 0 ? this.companies = response.data : this.companies = []
          this.companies.forEach(com => {
            if (typeof com.costedTransfer === "number" || typeof com.costedTransfer === "string") {
              if ((this.getWeight - this.stepMin) > 0) {
                console.log('Вес ' + this.getWeight)
                let p = this.getWeight - this.stepMin
                let i = 0
                console.log('Перевес на ' + p, 'Шаг перевеса ' + com.step_unlim)
                while(p > 0) {
                  p = p - com.step_unlim
                  i++
                }
                console.log('Кол-во шагов перевеса ' + i);
                com.costedTransfer = Number(com.costedTransfer) + Number(com.step_cost_unlim) * i
                console.log('-----')
              }
            } else if (typeof com.costedTransfer === "object" && com.costedTransfer !== null) {
              let costs = com.costedTransfer.slice()
              com.costedTransfer = null
              costs.some(cost => {
                if (this.getWeight >= cost.weight_to && this.getWeight < cost.weight_from) {
                  com.costedTransfer = Number(cost.cost)
                  return false;
                }
              })
            }
          })
        })
    },
    'country': function (after, before) {
      $('#city').text(null).val(null)
      this.city = null
    },
  },
  computed: {
    getCompanies () {
      if (this.city === null || this.country === null) {
        return []
      } else {
        let companies = [...this.companies]
        this.companies = []
        companies.forEach(com => {
          if (((com.costedTransfer === 0 && (Number(com.min_cost) <= Number(this.cost))) || (Number(com.min_cost) <= Number(this.cost))) && com.enabled && com.costedTransfer !== null) {
            this.companies.push(com)
          }
        })

        return this.companies
      }
    },
    getWeight () {
      let weight = 0;
      this.items.forEach(item => {
        weight += Number(item.weight)
      });
      return weight;
    },
    getCompany () {
      return this.company
    }
  },
  methods: {
    setCompany (company) {
      this.company = company
    }
  }
}
</script>
