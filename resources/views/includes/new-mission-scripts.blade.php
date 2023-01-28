@if ($errors->any() && session('error_type') == 'new mission')
    <script>
        $(document).ready(function(){
            let errors = @json($errors->all());
            let bag = '';
            errors.forEach(error => {
                bag += `<li>${error}<img height="14" class="ml-3" src="{{ asset('svg/times-circle.svg') }}" alt=""></i></li>`
            });
            $('#newMissionModal').modal('show');
            $('#newMissionErrorsList').html(bag);
            $('#newMissionErrorBag').removeClass('d-none');

            setTimeout(() => {
                $('#newMissionErrorBag').addClass('d-none');
            }, 10000);
        })
    </script>
@endif
<script>
    personSearch.addEventListener('keyup', e=>{
        e.stopPropagation();
        let s = e.target.value;
        let sBox = e.target.parentElement.querySelector('#search-result-wrapper');

        if(
            e.keyCode === 13 ||
            e.keyCode === 16 ||
            e.keyCode === 17 ||
            e.keyCode === 18 ||
            e.keyCode === 32 ||
            e.keyCode === 27 ||
            e.ctrlKey ||
            e.altKey
        ){
           return false;
        }

        if(s.length && s.length >= 3 ){ 
            sBox.innerHTML = '<div class="mid p-2"><img height="20" src="{{ asset('gif/loader.gif') }}" alt=""></div>';
            sBox.classList.remove('d-none');
            
            (async function(){
                const resObj = await fetch('{{ route('person-search') }}?search='+s);
                const res = await resObj.json();
                
                if(res.success == true && res.result.length){
                    sBox.innerHTML = '';
                    res.result.forEach( one => {
                        let element = document.createElement('div');
                        element.className =  'res';
                        element.textContent =  `${one.rank.name}/ ${one.name}`;
                        element.addEventListener('click', e=>{
                            sBox.classList.add('d-none');
                            sBox.innerHTML = '';

                            personNameDisplay.innerHTML = one.name;
                            personRankDisplay.innerHTML = one.rank.name;
                            personId.value = one.id;
                        })
                        sBox.appendChild(element);
                    })
                }else{
                    sBox.innerHTML = '<div class="mid p-2">لا يوجد</div>';
                }
            })()

        }else{
            sBox.classList.add('d-none');
        }
    });

    personSearch.addEventListener('blur', e=>{
        let sBox = e.target.parentElement.querySelector('#search-result-wrapper');
        setTimeout(()=>{
            sBox.classList.add('d-none');
            sBox.innerHTML = '';
        },300)
    })

    personSearch.addEventListener('focus', e=>{
        let s = e.target.value;
        let sBox = e.target.parentElement.querySelector('#search-result-wrapper');
        
        if(s.length && s.length >= 3 ){ 
            sBox.innerHTML = '<div class="mid p-2"><img height="20" src="{{ asset('gif/loader.gif') }}" alt=""></div>';
            sBox.classList.remove('d-none');
            
            (async function(){
                const resObj = await fetch('{{ route('person-search') }}?search='+s);
                const res = await resObj.json();
                
                if(res.success == true && res.result.length){
                    sBox.innerHTML = '';
                    res.result.forEach( one => {
                        let element = document.createElement('div');
                        element.className =  'res';
                        element.textContent =  `${one.rank.name}/ ${one.name}`;
                        element.addEventListener('click', e=>{
                            sBox.classList.add('d-none');
                            sBox.innerHTML = '';

                            personNameDisplay.innerHTML = one.name;
                            personRankDisplay.innerHTML = one.rank.name;
                            personId.value = one.id;
                        })
                        sBox.appendChild(element);
                    })
                }else{
                    sBox.innerHTML = '<div class="mid p-2">لا يوجد</div>';
                }
            })()

        }else{
            sBox.classList.add('d-none');
        }
    });

    document.querySelector('#newMissionModal select[name="categoryId"]').addEventListener('change', e=>{
        if(e.target.value == 1){
            // personSearch.disabled = true;
            // personId.disabled = true;
            missionTitle.disabled = false;

            // personInfo.classList.add('d-none');
        }else{
            // personSearch.disabled = false;
            // personId.disabled = false;
            missionTitle.disabled = true;

            // personInfo.classList.remove('d-none');
        }
    })
</script>