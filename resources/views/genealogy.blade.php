@include('includes.headcss')
@include('includes.header')
@include('includes.sideNavigation')

<link rel="stylesheet" href="{{ asset('assets/css/listree.min.css') }}">

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Genealogy</h4>
            </div>

            <div class="row">
                <div class="white-box">
                    <div class="panel-body">

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all_members">
                                <div class="search-form export-form">
                                    <div class="form-row">
                                        <div class="form-group" style="width: 100%; max-width: 410px;">
                                            <input id="wallet_address" name="wallet_address" type="text"
                                                value='{{ isset($data['wallet_address']) ? $data['wallet_address'] : '' }}'
                                                class="form-control" placeholder="Enter Wallet Address">
                                        </div>
                                        <div class="form-group">
                                            <button type="button" id="submit"
                                                class="btn btn-success">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="mytree" class="bstree maintreebox">
                            <ul>
                                <li class="tree_head bstree-node bstree-leaf">
                                    <div class="tree_name_main">I'd</div>
                                    <div class="tree_name_main">Level</div>
                                    <div class="tree_name_main">Date of Activation</div>
                                    <div class="tree_name_main">Total Team</div>
                                    <div class="tree_name_main">Total Directs</div>
                                    <div class="tree_name_main">Total Team Investment</div>
                                    <div class="tree_name_main">Direct Team Investment</div>
                                    <div class="tree_name_main">Self Investment</div>
                                </li>
                            </ul>
                            <ul class="no-data" >No Data</ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        @include('includes.footerJs')
        <script src={{ asset('assets/js/listree.umd.min.js') }}></script>
        <script type="text/javascript">
            // listree();
            $(document).on("click", "#submit", function() {

                const wallet_address = $('#wallet_address').val();
                loadRootTree(wallet_address);
            })

            function loadRootTree(wallet) {

                // Remove old tree data (except header)
                $("#mytree ul:not(:first)").remove();

                const apiUrl = "{{ route('user_genealogy') }}";
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                fetch(apiUrl, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        body: JSON.stringify({
                            wallet_address: wallet,
                            type: "API"
                        }),
                    })
                    .then(res => res.json())
                    .then(data => {

                        if (!data.data || data.data.length === 0) {
                            alert("No data found");
                            return;
                        }

                        let html = `<ul>`;

                        data.data.forEach(val => {
                            html+=`<li class="tree_part_main_li bstree-node bstree-composite" data-level="1">`
                            if(val.my_direct > 0){
                                html+=`<div class="bstree-inner-container"
                                    onclick="getNextLeg('${val.wallet_address}', this, 1)">
                                    <span class="bstree-chevron" title="Close">
                                        <div class="tree_plus_minus">+</div>&nbsp;
                                    </span>
                                </div>`
                            }
                            
                            html += `<div class="tree_part_line_main">
                            <div class="tree_name_main">
                                <img src="{{ asset('assets/images/logo.png') }}">
                                ${val.refferal_code}
                            </div>
                            <div class="tree_name ">${val.level}</div>
                           
                            <div class="tree_name">${val.currentPackageDate}</div>
                            <div class="tree_name">${val.my_team}</div>
                            <div class="tree_name">${val.my_direct}</div>
                            <div class="tree_name">${parseFloat(val.team_investment).toFixed(2)}</div>
                            <div class="tree_name">${parseFloat(val.direct_investment).toFixed(2)}</div>
                            <div class="tree_name">${parseFloat(val.totalInvestment).toFixed(2)}</div>
                        </div>
                    </li>
                `;
                        });

                        html += '</ul>';

                        $("#mytree").append(html);
                    });
            }

            $('document').ready(function() {
                $('#mytree').bstree({
                    updateNodeTitle: function(node, title) {

                        return '<span class="label label-default">' + node.attr('data-id') + '</span> ' +
                            title
                    }
                })
            })
            // Define a flag to keep track of expanded nodes
            const expandedNodes = {};



            function getNextLeg(x, element, level) {
                const closestLi = element.closest('.tree_part_main_li');

                closestLi.classList.remove('bstree-expanded');
                closestLi.classList.add('bstree-closed');

                closestLi.querySelectorAll('.bstree-children').forEach(childNode => {
                    // childNode.style.display = 'none';
                    if (childNode.style.display === 'block') {
                        childNode.style.display = 'none';
                    } else {
                        childNode.style.display = 'block';
                    }
                });

                const chevronElements = element.querySelectorAll('.bstree-chevron');

                let title;
                chevronElements.forEach((chevronElement, i) => {
                    title = chevronElement.getAttribute('title');
                    // console.log(chevronElement.innerHTML);
                    if (closestLi.getAttribute('data-level') > 1) {
                        if (chevronElement.innerHTML == '<div class="tree_plus_minus">-</div>&nbsp;') {
                            chevronElement.innerHTML = '<div class="tree_plus_minus">+</div>&nbsp;';
                        } else {
                            chevronElement.innerHTML = '<div class="tree_plus_minus">-</div>&nbsp;';
                        }
                    } else {
                        if (chevronElement.innerHTML == '<div class="tree_plus_minus">-</div>&nbsp;') {
                            chevronElement.innerHTML = '<div class="tree_plus_minus">+</div>&nbsp;';
                        } else {
                            chevronElement.innerHTML = '<div class="tree_plus_minus">+</div>&nbsp;';
                        }
                    }
                });

                if (title == "Close") {
                    const apiUrl = "{{ route('user_genealogy') }}";
                    const params = {
                        wallet_address: x,
                        type: 'API'
                    };

                    level = level + 1;

                    // Check if the node has already been expanded
                    if (!expandedNodes[x]) {
                        // Mark the node as expanded
                        expandedNodes[x] = true;

                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


                        // Make a POST request to the API
                        fetch(apiUrl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                },
                                body: JSON.stringify(params),
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Handle the API response data as needed
                                if (data['data'].length > 0) {
                                    let htmlNextLeg = '';
                                    for (let i = 0; i < data['data'].length; i++) {
                                        let displayRank = data['data'][i]['rank'] != null ? data['data'][i]['rank'] :
                                            'No Rank';
                                        htmlNextLeg +=
                                            `<ul style="display:block" id="mytreeTwo" class="bstree-children">
                                              <i class="bstree-vline" data-vitems="9"></i>
                                              <li class="tree_part_main_li bstree-node bstree-composite bstree-expanded" data-id="" data-level="` +
                                            level + `">`;

                                        if (data['data'][i][data['data'][i]['refferal_code']] !== undefined) {
                                            if (data['data'][i][data['data'][i]['refferal_code']].length > 0) {
                                                htmlNextLeg += `<div class="bstree-inner-container" onclick="getNextLeg('` +
                                                    data['data'][i]['wallet_address'] + `', this, ` + level + `)">
                                                    <span class="bstree-chevron" title="Close"><div class="tree_plus_minus">+</div>&nbsp;</span>
                                                    <label class="bstree-label-container">
                                                        <span class="bstree-icon"></span>
                                                        <span class="bstree-icon"></span>
                                                        <span class="bstree-label">
                                                        <span class="label label-default"></span>
                                                        </span>
                                                    </label>
                                                 </div>`;
                                            } else {
                                                htmlNextLeg +=
                                                    `<div class="bstree-inner-container"><label class="bstree-label-container"></label></div>`;
                                            }
                                        } else {
                                            htmlNextLeg +=
                                                `<div class="bstree-inner-container"><label class="bstree-label-container"></label></div>`;
                                        }

                                        htmlNextLeg += `<div class="tree_part_line_main">
                                                <div class="tree_name_main">
                                                   <img src="{{ asset('assets/images/logo.png') }}" class="object-contain" alt="">
                                                   ` + data['data'][i]['refferal_code'] + `
                                                </div>
                                                
                                                <div class="tree_name">` + data['data'][i]['level'] + `</div>
                                                <div class="tree_name">` + data['data'][i]['currentPackageDate'] + `</div>
                                                <div class="tree_name">` + data['data'][i]['my_team'] + `</div>
                                                <div class="tree_name">` + data['data'][i]['my_direct'] + `</div>
                                                <div class="tree_name">` + parseFloat(data['data'][i][
                                            'team_investment'
                                        ]).toFixed(2) + `</div>
                                                <div class="tree_name">` + parseFloat(data['data'][i][
                                            'direct_investment'
                                        ]).toFixed(2) + `</div>
                                                <div class="tree_name">` + parseFloat(data['data'][i][
                                            'totalInvestment'
                                        ]).toFixed(2) + `</div>
                                             </div>
                                          </li>
                                       </ul>`
                                    }
                                    const parentElement = element.parentElement;
                                    parentElement.insertAdjacentHTML('beforeend', htmlNextLeg);

                                    chevronElements.forEach((chevronElement, i) => {
                                        title = chevronElement.getAttribute('title');
                                        // console.log(chevronElement.innerHTML);
                                        if (closestLi.getAttribute('data-level') == 1) {
                                            if (chevronElement.innerHTML ==
                                                '<div class="tree_plus_minus">-</div>&nbsp;') {
                                                chevronElement.innerHTML =
                                                    '<div class="tree_plus_minus">+</div>&nbsp;';
                                            } else {
                                                chevronElement.innerHTML =
                                                    '<div class="tree_plus_minus">-</div>&nbsp;';
                                            }
                                        }
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                    }
                }
            }
        </script>

        @include('includes.footer')
