@extends('layouts.admin')

@section('content')
<div class='list'></ul>
@stop

@section('stylesheets')
{{Html::style('css/admin.css') }}
<style>
  .bar {

margin: 2px;
}
.bar::after{
  background: black;
  height: 40px;
  width: 40px;
}
.bar:hover{
  fill: pink;
}

/*  rect:nth-child(1):hover + rect{
visibility: visible;
}
g > .text-group-item{
visibility: hidden;
} */
.text-group-item{
visibility: hidden;
}
  /*
  rect + text {
    visibility: hidden;
  }
  rect:nth-child(1):hover + rect, rect:nth-child(1):hover ~ text:nth-child(3){
    visibility: visible; */
  }
  </style>
  <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css"/>
@stop

@section('scripts')
<script src="https://d3js.org/d3.v5.min.js"></script>
<script>
    let scale = d3.scaleLinear();
    let output = scale(50);

var scores = @json($scores);

scale.domain()
var scores = @json($scores, JSON_PRETTY_PRINT);
let container = document.getElementsByClassName('list')[0];

let svgHeight = 800, svgWidth=container.offsetWidth;
let svgContainer  = d3.select(".list").append('svg').attr('width', svgWidth).attr('height', svgHeight);
let tooltipBoxHeight = 100, tooltipBoxWidth = 200;
let barGraph = svgContainer.append('g').attr('class', 'bar-graph').selectAll('g').data(scores).enter();
/* selectAll('g').data(scores).enter().append('g'); */

barGraph.append('rect').attr('width', 25).attr('height', score=>score[1]).attr('x', (score,index)=>index*30).attr('y',score=>svgHeight-score[1])
.attr('fill', score=>score[1]> 60 ? 'green': 'black').attr('class', 'bar');
let textGroupItem = barGraph.append('g').attr('class', 'text-group-item');

textGroupItem.insert('rect').attr('width', tooltipBoxWidth).attr('height', tooltipBoxHeight)
.attr('x', (score,index)=>index*30)
.attr('y', score=>svgHeight-score[1]-tooltipBoxHeight).attr('fill', '#FFD3AA')
.attr('stroke', 'black').attr('stroke-width', 2).style('box-sizing', 'border-box') 

textGroupItem.insert('text').attr('x', (score,index)=>index*30+tooltipBoxWidth/2-(score[0] + score[1]).length ).attr('y', score=>svgHeight-score[1]-tooltipBoxHeight/2+5).text(score=>{
  return `${score[0]}:${score[1]}`;
}) 
/*
/* let enterSelection = svg.selectAll('g').data(scores).enter();
let groups = enterSelection.append('g').insert('rect'); */
/* let rectangles = enterSelection.append('rect').attr('width', 25).attr('height', score=>score).attr('x', (score,index)=>index*30).attr('y',score=>svgHeight-score)
.attr('fill', score=>score> 60 ? 'green': 'black').attr('class', 'bar'); */
/* 
let tooltips = enterSelection.insert('rect').attr('width', 200).attr('height', 50).attr('x', (score,index)=>index*30+25).attr('y',score=>svgHeight-score-30)
.attr('fill', 'orange').style('visibility', 'hidden')

svg.selectAll('text').data(scores).enter().append('text').attr('x', (score,index)=>index*30).attr('y',score=>svgHeight-score-3).text(score=>score).style('font-size', '20px')
.append('title').text('some text') */ 
      /* .data(scores)
      .enter()
      .append("div").attr('class', 'bar').style("height", (score)=>3*score + 'px'); */
</script>
@stop