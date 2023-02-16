@extends('master')

@push('title')
    Organization Chart
@endpush

@section('content')

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/networkgraph.js"></script>
    {{-- <script src="https://code.highcharts.com/modules/exporting.js"></script> --}}


    <style type="text/css">
        #container {
            min-width: 320px;
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
    <div id="container"></div>

    @push('scripts')
    <script type="text/javascript">
        // Add the nodes option through an event call. We want to start with the parent
        // item and apply separate colors to each child element, then the same color to
        // grandchildren.
        Highcharts.addEvent(
            Highcharts.Series,
            'afterSetOptions',
            function(e) {
                var colors = Highcharts.getOptions().colors,
                    i = 0,
                    nodes = {};

                if (
                    this instanceof Highcharts.seriesTypes.networkgraph &&
                    e.options.id === 'lang-tree'
                ) {
                    e.options.data.forEach(function(link) {

                        if (link[0] === 'Firdaus Santoso') {
                            nodes['Firdaus Santoso'] = {
                                id: 'Firdaus Santoso',
                                marker: {
                                    radius: 30
                                }
                            };

                            nodes[link[1]] = {
                                id: link[1],
                                marker: {
                                    radius: 10
                                },
                                color: colors[i++]
                            };



                        } else if (nodes[link[0]] && nodes[link[0]].color) {
                            nodes[link[1]] = {
                                id: link[1],
                                color: nodes[link[0]].color
                            };
                        }
                    });

                    e.options.nodes = Object.keys(nodes).map(function(id) {
                        return nodes[id];
                    });
                }
            }
        );

        Highcharts.chart('container', {
            chart: {
                type: 'networkgraph',
                height: '100%'
            },
            title: {
                text: 'Organization Chart IT Services'
            },
            subtitle: {
                text: ''
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                networkgraph: {
                    keys: ['from', 'to'],
                    layoutAlgorithm: {
                        enableSimulation: true,
                        friction: -0.9
                    }
                }
            },
            series: [{
                dataLabels: {
                    enabled: true,
                    linkFormat: ''
                },
                id: 'lang-tree',
                data: [
                    ['Firdaus Santoso', 'Tjandra Hadiwidjaja'],
                    ['Firdaus Santoso', 'Marini Susanti'],
                    ['Firdaus Santoso', 'Dana Ardiansyah'],
                    ['Tjandra Hadiwidjaja', 'Yudi Muji Prasetyo'],
                    ['Tjandra Hadiwidjaja', 'Filsuf Hidayat'],
                    ['Tjandra Hadiwidjaja', 'Hendrian Rajitama'],
                    ['Tjandra Hadiwidjaja', 'Febri Dwi Santoso'],
                    ['Marini Susanti', 'Normiati'],
                    ['Febri Dwi Santoso', 'Bondan Handoko'],
                    ['Febri Dwi Santoso', 'Rony Febriadi'],
                    ['Febri Dwi Santoso', 'Abdus Shahrir Rozaq'],
                    ['Marini Susanti', 'Khasan Soleh'],
                    ['Marini Susanti', 'Denok Puspitasari'],
                    ['Marini Susanti', 'Ika Kurniasari'],
                    ['Marini Susanti', 'Marien Mutiara'],
                    ['Marini Susanti', 'Albertus Wellma Sandria Kusuma'],
                    ['Normiati', 'Desy Zulfiany Juwita'],
                    ['Normiati', 'Dwi Handoko'],
                    ['Filsuf Hidayat', 'Gilang Tresna'],
                    ['Filsuf Hidayat', 'Tri Margiono'],
                    ['Filsuf Hidayat', 'Tjahyadi Wijaya'],
                    ['Filsuf Hidayat', 'Vincentius Henry'],

                    ['Hendrian Rajitama', 'Sigid Susetyo'],
                    ['Hendrian Rajitama', 'Abraham Kristianto'],
                    ['Hendrian Rajitama', 'Aditya Darmawan'],
                    ['Hendrian Rajitama', 'Afib Asyari'],
                    ['Hendrian Rajitama', 'Alief Ghuruf Al Faris'],
                    ['Hendrian Rajitama', 'Liem Reza Johansaputra Wananegara'],
                    ['Hendrian Rajitama', 'Rendra Yuwono Wicaksono'],
                    ['Hendrian Rajitama', 'Stifanus Benny Sabdiyanto'],
                    ['Dana Ardiansyah', 'Serny Datu Rantetampang'],
                    ['Dana Ardiansyah', 'Nanda Sabrina'],
                    ['Dana Ardiansyah', 'Chandra Kusuma'],
                    ['Dana Ardiansyah', 'Nourma Yunita'],
                    ['Dana Ardiansyah', 'Ambar Hamim'],
                    ['Dana Ardiansyah', 'Novita Handariati'],

                    ['Yudi Muji Prasetyo', 'Syuchrisyanto Hari Susanto'],
                    ['Yudi Muji Prasetyo', 'Muhammad Lukman'],
                    ['Yudi Muji Prasetyo', 'Mohamad Faizal Rohman'],
                    ['Yudi Muji Prasetyo', 'Hendra Yunianto Tri Sarjana'],


                ]
            }]
        });
    </script>
    @endpush
@endsection
