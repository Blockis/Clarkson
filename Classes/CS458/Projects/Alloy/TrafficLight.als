--	Paul Burgwardt
--	Ryan Parece

--	Formal Methods
--	CS458

--	Traffic Light
--	We have created a model of a four-way intersection with a traffic light, written in Alloy.
--
--	We are assuming that opposite lanes will maintain the same state,
--		where as lanes N and S will be the same state, and W and E will be the same state.
--
-- We have implemented a pedestrian crossing feature. This allows a pedestrian to be randomly generated.
--		Once generated, the pedestrian will be in a 'waiting' state, until both lanes are 'red'.
--		Once both are in the red state, a pedestrian will randomly choose to walk either in the NS or EW direction
--
-- We have implemented proper error checking to make sure our model is balanced, 
-- 		and that no catastrophic events will occur (e.g. a pedestrian walking across active / moving traffic).
--


--
-- We have included a picture of our model below:	
--
--                 |	N	|
--	___________|		|____________
--					
--	W 					x				E
--	___________		 ____________
--					|		|
--					|	S	|
--
--

open util/integer	// Allows using of int
open util/ordering[State]	// Ordering based on State signature

// Colors
sig Color {}

// Red, Yellow, Green colors extend Color
sig Red, Yellow, Green extends Color {}

// states extend Pedestrian
sig PedestrianState{}
sig NotPresent, Waiting, WalkingAcross extends PedestrianState {}

// Order is based off this signature
sig State {
	NS : Color, //*********************
	EW :Color, //********************
	PED : PedestrianState,//***********************
	step : Int
}

// Initialization
fact {
	first.NS = Red // Initialize NS color to red
	first.EW = Red // Initialize EW color to red
	first.PED = NotPresent // Initialize Pedestrian to not present
	first.step = 0
}

// Step through the States
fact {
	all s : State, s' : s.next {
		// Both lights are red
		(s.step = 0) => {
            s'.NS = Green //*******************************
			s'.EW = Red //********************************
            s'.PED = NotPresent//****************************
			s'.step = 1 // Next step is 1
		}
		(s.step = 1) => {
			s'.NS = Yellow
			s'.EW = Red
			s'.PED = NotPresent
			s'.step = 2
		}
		(s.step = 2) => {
			s'.NS = Red
			s'.EW = Red
			s'.PED = NotPresent
			s'.step = 3
		}
		(s.step = 3) => {
			s'.NS = Red
			s'.EW = Green
			s'.PED = NotPresent
			s'.step = 4
		}
		(s.step = 4) => {
			s'.NS = Red
			s'.EW = Yellow
			s'.PED = NotPresent
			s'.step = 5
		}
		(s.step = 5) => {
			s'.NS = Red
			s'.EW = Red
			s'.PED = NotPresent
			s'.step = 6
		}
		(s.step = 6) => {
			s'.NS = Red
			s'.EW = Red
			s'.PED = Waiting
			s'.step = 7
		}
		(s.step = 7) => {
			s'.NS = Red
			s'.EW = Red
			s'.PED = WalkingAcross
			s'.step = 0
		}
	}
}

pred	go {}

// SET SAIL
run go for 9
