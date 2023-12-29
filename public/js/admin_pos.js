async function loadDatabase() {
    const db = await idb.openDB("cater_choice_store", 2, {
        upgrade(db, oldVersion, newVersion, transaction) {
            if(newVersion==1 || oldVersion==0){
                db.createObjectStore("products", {
                    keyPath: "id",
                    autoIncrement: true,
                });
                db.createObjectStore("sales", {
                    // keyPath: "productId",
                    keyPath: ["productId", "price"],
                    // autoIncrement: true,

                });
            }
            if(newVersion==2){
            
                db.createObjectStore("pauses", {
                    keyPath: "id",
                    autoIncrement: true,
                });
            }
            
        },
    });

    return {
        db,
        getProducts: async() => await db.getAll("products"),
        addProduct: async(product) => await db.put("products", product),
        editProduct: async(product) =>
            await db.put("products", product.id, product),
        deleteProduct: async(product) => await db.delete("products", product.id),
        getCarts: async() => await db.getAll("sales"),
        addCart: async(sale) => await db.add("sales", sale),
        updateCart: async(sale) => await db.put("sales", sale),
        // deleteCart: async(sale) => await db.delete("sales", sale.productId),
        deleteCart: async(sale) => await db.delete("sales", [sale.productId ,sale.price]),
        emptyCart: async(sale) => await db.clear("sales"),
        emptyProducts: async(sale) => await db.clear("products"),
        getPauseList: async() => await db.getAll("pauses"),
        addPauseList: async(pause) => await db.put("pauses", pause),
        deletePause: async(pause) => await db.delete("pauses", pause.id),

    };
}

function initApp() {
    const app = {
        db: null,
        time: null,
        pausePopup:false,
        mobileMenu:false,
        pauseList:false,
        pauses:[],
        firstTime: localStorage.getItem("first_time") === null,
        activeMenu: 'pos',
        loadingSampleData: false,
        moneys: [2000, 5000, 10000, 20000, 50000, 100000],
        products: [],
        keyword: "",
        category: "",
        brand: "",
        cart: [],
        cash: 0,
        change: 0,
        isShowModalReceipt: false,
        receiptNo: null,
        receiptDate: null,
        loading: false,
        isCreditCard: false,
        isSubmitting: false,
        isFavorite: false,
        clearCart: false,
        sale: {},
        order_id: document.getElementById('pos-order-id').value,
        user_id: document.getElementById('pos-user-id').value,
        branch_id: document.getElementById('pos-branch-id').value,

        async initDatabase() {
            this.db = await loadDatabase();
            this.loadProducts();
            this.loadCarts();

        },
        async loadProducts() {
            this.loading = true;
            this.products = await this.db.getProducts();
            this.loading = false;
            if (document.getElementById('pos-product-count').value != this.products.length) {
                await this.db.emptyProducts();

                this.startWithSampleData(1);
            }


        },
        async loadCarts() {
            this.cart = await this.db.getCarts();
            this.cash = this.getTotalPrice();
        },
        async startWithSampleData1(page) {
            this.loading = true;
            const json = await fetch(document.getElementById('pos-product-list').value + "?page=" + page);

            if (json != undefined) {
                if (json.status == 200) {
                    const data = await json.json();
                    for (let product of data.data) {

                        await this.db.addProduct({
                            id: product.product_id,
                            name: product.product.name,
                            code: product.product.code,
                            pack_size: product.product.pack_size,
                            category_id: product.cate,
                            brand_id: product.product.brand_id,
                            // image: "https://cater-choice-assets.s3.eu-west-2.amazonaws.com/storage/thumbnail/" + product.product.image.split(",")[0],
                            image: "https://cater-choice-assets.s3.eu-west-2.amazonaws.com/storage/" + product.product.image.split(",")[0],
                            // price: product.sale_price,
                            price: product.price,
                            p_price: product.p_price,
                            // tax_rate: (product.product ? .tax ? .rate || 0),
                            tax_rate: (product.product?.tax?.rate || 0),
                            // tax_rate: product.tax.rate,
                            // tax_rate: 0,
                            isTaxCalculate: product.product.tax_method == 1 ? true : false,
                            is_favorite: product.is_favorite == 1 ? true : false,
                            options: null
                        });
                    }
                    if (data.is_more) {
                        this.startWithSampleData(page + 1);
                    } else {
                        this.products = await this.db.getProducts();
                        this.loading = false;
                    }
                }
            }

        },
        async startWithSampleData(page) {
            this.loading = true;
            const json = await fetch(document.getElementById('pos-product-list').value + "?page=" + page);

            if (json != undefined) {
                if (json.status == 200) {
                    const data = await json.json();
                    for (let product of data.data) {
                        let placeholderImageUrl = "https://fakeimg.pl/200x200";
                        let imageUrl = ""; // Default empty URL

                        if (product.product.image !== null && product.product.image !== undefined && product.product.image !== "") {
                            imageUrl = "https://cater-choice-assets.s3.eu-west-2.amazonaws.com/storage/thumbnail/" + product.product.image.split(",")[0];

                            // let imagePath = product.product.image.split(",")[0];
                            // try {
                            //     const s3 = fetch(document.getElementById('amazon-s3').value + "?page=" + page, {
                            //         method: 'POST',
                            //         headers: {
                            //             'Content-Type': 'application/json',
                            //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            //         },
                            //         body: JSON.stringify({
                            //             imagePath: imagePath,
                            //             productId: product.product_id,
                            //         }),
                            //     });
                            //
                            //     const s3Response = await s3;
                            //     // console.log('s3Response', s3Response);
                            //
                            //     if (s3Response.ok) {
                            //         // Check if the response is JSON
                            //         const contentType = s3Response.headers.get('content-type');
                            //         if (contentType && contentType.includes('application/json')) {
                            //             const s3Data = await s3Response.json();
                            //             if (s3Data.exists) {
                            //                 imageUrl = "https://cater-choice-assets.s3.eu-west-2.amazonaws.com/storage/thumbnail/" + imagePath;
                            //             } else {
                            //                 // If the image doesn't exist in S3, set the image URL to the placeholder
                            //                 imageUrl = placeholderImageUrl;
                            //             }
                            //         } else {
                            //             console.error('Error: Response is not JSON');
                            //             imageUrl = placeholderImageUrl;
                            //         }
                            //     } else {
                            //         console.error('Error: Response not OK');
                            //         imageUrl = placeholderImageUrl;
                            //     }
                            // } catch (error) {
                            //     console.error('Error checking image existence:', error);
                            //     // If there's an error, set the image URL to the placeholder
                            //     imageUrl = placeholderImageUrl;
                            // }
                        } else {
                            imageUrl = placeholderImageUrl;
                        }

                        await this.db.addProduct({
                            id: product.product_id,
                            name: product.product.name,
                            code: product.product.code,
                            pack_size: product.product.pack_size,
                            category_id: product.cate,
                            brand_id: product.product.brand_id,
                            image: imageUrl,
                            price: product.price,
                            p_price: product.p_price,
                            tax_rate: (product.product?.tax?.rate || 0),
                            isTaxCalculate: product.product.tax_method == 1 ? true : false,
                            is_favorite: product.is_favorite == 1 ? true : false,
                            options: null
                        });
                    }

                    if (data.is_more) {
                        await this.startWithSampleData(page + 1);
                    } else {
                        this.products = await this.db.getProducts();
                        this.loading = false;
                    }
                }
            }
        },

        startBlank() {
            this.setFirstTime(false);
        },
        popupOpen() {
            this.pausePopup = true;
        },
        popupClose() {
            this.pausePopup = false;
        },
        async pauseSale(){
            const carts = await this.db.getCarts();
            const list = await this.db.getPauseList();
            await this.db.addPauseList({
                id: Math.floor(Math.random() * 1000),
                name: "Hold "+(list.length+1),
                carts:JSON.stringify(carts)
            });
            await this.db.emptyCart();
            this.pausePopup = false;
            this.cart = [];
        },
        async pauseSaleList(){
            this.pauseList = !this.pauseList;
            this.pauses = await this.db.getPauseList();

        },
        async removePause(item){
            await this.db.deletePause(item);
            this.pauses = await this.db.getPauseList();
        },
        async retakePause(item){
            await this.db.deletePause(item);
            const list = await this.db.getPauseList();
            this.pauses = list;
            const carts = JSON.parse(item.carts);
            for (let cart of carts) {
                await this.db.updateCart(cart);
            }
            this.loadCarts();
            


        },
        setFirstTime(firstTime) {
            this.firstTime = firstTime;
            if (firstTime) {
                localStorage.removeItem("first_time");
            } else {
                localStorage.setItem("first_time", new Date().getTime());
            }
        },
        filteredProducts() {
            const rg = this.keyword ? new RegExp(this.keyword, "gi") : null;
            let products = this.products.filter((p) => !rg || p.name.match(rg) || p.code.match(rg));
            products = products.filter((p) => !this.category || p.category_id == this.category);
            products = products.filter((p) => !this.brand || p.brand_id == this.brand);
            if (products.length === 1) {
                if (products[0].code == this.keyword) {
                    this.addToCart(products[0]);
                    this.keyword = '';
                }
            }
            return products;
        },
        async favoriteProducts() {
            this.isFavorite = !this.isFavorite;
            let products = await this.db.getProducts();
            if (this.isFavorite) {

                this.products = products.filter((p) => p.is_favorite == true);
            } else {
                this.products = products;
            }


        },
        // async addToCart(product) {
        //     var price;
        //     if (product.price && !product.p_price){
        //         price = product.price
        //     }else if(product.p_price && !product.price){
        //         price = product.p_price
        //     }
        //     console.log('price', price)
        //     const index = this.findCartIndex(product);
        //     let item = {
        //         productId: product.id,
        //         image: product.image,
        //         name: product.name,
        //         // price: product.price,
        //         price: price,
        //         option: product.option,
        //         tax: product.isTaxCalculate ? product.tax_rate : 0,
        //         qty: 1,
        //     };
        //     if (index === -1) {
        //         this.cart.push(item);
        //     } else {
        //         this.cart[index].qty += 1;
        //         item = {
        //             ...item,
        //             qty: item.qty = this.cart[index].qty
        //         }
        //     }
        //     await this.db.updateCart(item);
        //
        //     this.beep();
        //     this.updateChange();
        // },

        async addToCart2(product, priceType) {
            var price = {};

            if (priceType === 'price' && product.price !== undefined) {
                price.type = 'price';
                price.value = product.price;
            } else if (priceType === 'p_price' && product.p_price !== undefined) {
                price.type = 'p_price';
                price.value = product.p_price;
            } else {
                return; // Invalid priceType, do nothing
            }

            // Find the existing cart item
            const existingCartItem = this.cart.find(item => item.productId === product.id && item.price === price.value);

            if (existingCartItem) {
                // If the item already exists with the same product and price type, update its quantity
                existingCartItem.qty += 1;
                await this.db.updateCart(existingCartItem);
                console.log('existingCartItem')
            } else {
                // If the item does not exist, create a new cart item
                let item = {
                    productId: product.id,
                    image: product.image,
                    name: product.name,
                    price: price.value,
                    option: product.option,
                    tax: product.isTaxCalculate ? product.tax_rate : 0,
                    qty: 1,
                };
                this.cart.push(item);
                await this.db.updateCart(item);
                console.log('NOT existingCartItem')

            }

            this.beep();
            this.updateChange();
        },


        async addToCart(product, priceType) {
            console.log('tax', product.tax_rate)

            const index = this.findCartIndex(product);
            var price = {};

            if (priceType === 'price' && product.price !== undefined) {
                price.type = 'price';
                price.value = product.price;
            } else if (priceType === 'p_price' && product.p_price !== undefined) {
                price.type = 'p_price';
                price.value = product.p_price;
            }

                const existingProductIndex = this.cart.findIndex((cartItem) => {
                    // return cartItem.productId === product.id && cartItem.price === product.price;
                    return cartItem.productId === product.id && cartItem.price === price.value;
                });
                let item = {
                    productId: product.id,
                    image: product.image,
                    name: product.name,
                    // price: product.price,
                    price: price.value,
                    option: product.option,
                    // tax: product.isTaxCalculate ? product.tax_rate : 0,
                    tax: product.tax_rate,
                    qty: 1,
                };

                if (existingProductIndex === -1) {
                    this.cart.push(item);
                } else {
                    this.cart[existingProductIndex].qty += 1;
                    item.qty = this.cart[existingProductIndex].qty;
                }

                console.log('item', item)

                await this.db.updateCart(item);

                this.beep();
                this.updateChange();

        },

        findCartIndex(product) {
            return this.cart.findIndex((p) => p.productId === product.id && p.price === product.price);
        },
        async addQty(item, qty) {
            const index = this.cart.findIndex((i) => i.productId === item.productId && i.price === item.price);
            if (index === -1) {
                return;
            }
            const afterAdd = item.qty + qty;
            if (afterAdd === 0) {
                this.cart.splice(index, 1);
                await this.db.deleteCart(item);
                // await this.db.deleteCart(item.price, item.productID);

                this.clearSound();
            } else {
                this.cart[index].qty = afterAdd;
                item = {
                    ...item,
                    qty: item.qty = this.cart[index].qty
                }
                await this.db.updateCart(item);
                this.beep();
            }
            this.updateChange();
        },
        addCash(amount) {
            this.cash = (this.cash || 0) + amount;
            this.updateChange();
            this.beep();
        },
        getItemsCount() {
            return this.cart.reduce((count, item) => count + item.qty, 0);
        },
        updateChange() {
            this.cash = this.getTotalPrice();
            this.change = this.cash - this.getTotalPrice();
        },
        updateCash(value) {
            this.cash = parseFloat(value.replace(/[^0-9]+/g, ""));
            this.updateChange();
        },
        getSubTotalPrice() {
            return this.cart.reduce(
                (total, item) => total + item.qty * item.price,
                0
            );
        },
        getTotalPrice() {
            return this.cart.reduce(
                (total, item) => total + item.qty * item.price + item.qty * ((item.price * item.tax) / 100),
                0
            );
        },
        getTotalTax() {
            return this.cart.reduce(
                (total, item) => total + item.qty * ((item.price * item.tax) / 100),
                0
            );
        },
        submitable() {
            return (this.cash > 0 && this.change >= 0) && this.cart.length > 0;
        },
        submit(flag) {
            this.isCreditCard = flag;
            const time = new Date();
            this.isShowModalReceipt = true;
            this.receiptNo = `CC-POS-${Math.round(time.getTime() / 1000)}`;
            this.receiptDate = this.dateFormat(time);
        },
        closeModalReceipt() {
            this.isShowModalReceipt = false;
        },
        dateFormat(date) {
            const formatter = new Intl.DateTimeFormat('id', { dateStyle: 'short', timeStyle: 'short' });
            return formatter.format(date);
        },
        currency() {
            return document.getElementById('pos-currency').value;
        },
        numberFormat(number) {
            return (number || "")
                .toString()
                //.replace(/^0|\./g, "")
                .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        },
        priceFormat(number) {

            // return number ? `${this.currency()} ${this.numberFormat(number)}` : `${this.currency()} 0`;
            return number ? `${this.currency()} ${this.numberFormat(number.toFixed(2))}` : `${this.currency()} 0`
        },
        sale() {
            return {
                order_id: this.order_id,
                user_id: this.user_id,
                branch_id: this.branch_id,
                // reference_no: this.receiptNo,
                item: this.cart.length,
                total_qty: this.getItemsCount(),
                total_discount: 0,
                total_tax: 0,
                total_price: this.getTotalPrice(),
                grand_total: this.getTotalPrice(),
                order_tax_rate: 0,
                order_tax: this.getTotalTax(),
                order_discount_type: null,
                order_discount_value: 0,
                order_discount: 0,
                sale_status: 1,
                payment_status: 'pending',
                paid_amount: this.getTotalPrice(),
                coupon_discount: null,
                coupon_id: null,
                status: 'POS',
                items: this.cart
            };
        },
        clear() {
            this.cash = 0;
            this.cart = [];
            this.receiptNo = null;
            this.receiptDate = null;
            this.updateChange();
            this.clearSound();
            this.db.emptyCart();
        },
        beep() {
            this.playSound("../sound/sound_beep.mp3");
        },
        clearSound() {
            this.playSound("../sound/sound_button.mp3");
        },
        playSound(src) {
            const sound = new Audio();
            sound.src = src;
            sound.play();
            sound.onended = () => delete(sound);
        },
        async printAndProceed() {
            this.isSubmitting = true;
            const rawResponse = await fetch(document.getElementById('pos-sale-submit').value, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(this.sale())
            });
            const content = await rawResponse.json();
            this.isSubmitting = false;
            if (rawResponse.status == 200) {
                const receiptContent = document.getElementById('receipt-content');
                const titleBefore = document.title;
                const printArea = document.getElementById('print-area');

                printArea.innerHTML = receiptContent.innerHTML;
                document.title = this.receiptNo;

                window.print();
                this.isShowModalReceipt = false;

                printArea.innerHTML = '';
                document.title = titleBefore;

                // TODO save sale data to database

                this.clear();
            }


        }
    };

    return app;
}