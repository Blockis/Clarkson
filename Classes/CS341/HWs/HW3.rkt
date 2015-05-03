; Paul Burgwardt
; CS341 Programming Languages
; HW3

#lang racket

;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
; board
;  object representation of a sliding puzzle board
;  internally uses vectors (resizeable arrays)
;  this version is text-based (for MIT Scheme)
;  for simplicity, assume size equals 3 
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
(define board
  (lambda (size) 
	  (let ((board (make-initialized-vector (square size) (lambda (x) x))) 
		(blank 0))
	       (letrec ((this (lambda message 
		       (case (car message) 
			     ((size) 
			      ; returns the total number of cells on the board
			      (square size)) 
			     ((get-item) 
			      ; returns the tile on position (x,y) on the board
			      ; [ FILL IN ]
			      #t)
			     ((get-position)
			      ; returns the flat position of the tile 
			      ; [ FILL IN ]
			      #t)
			     ((show) 
			      ; outputs the board 
			      (display-board board size)) 
			     ((stay) 
			      ; do nothing! actually useful in some scenarios
			      #t)		
			     ((move-down) 
			      ; moves the blank tile down one position
			      (if (not (last-row? blank size)) 
				  (let ((i (get-row blank size)) (j (get-column blank size))) 
				       (let ((item (board-ref board size (+ i 1) j))) 
					    (begin 
					     (vector-set! board blank item) 
					     (vector-set! board (flat-index (+ i 1) j size) 0) 
					     (set! blank (flat-index (+ i 1) j size))
					     (this 'show))))))
			     ((move-up) 
			      ; moves the blank tile up one position
			      ; [ FILL IN ]
			      #t)
			     ((move-left) 
			      ; moves the blank tile left one position
			      ; [ FILL IN ]
			      #t)
			     ((move-right) 
			      ; moves the blank tile right one position
			      ; [ FILL IN ]
			      #t)
			     ((shuffle)
			      ; randomly shuffles the board a number of times
			      (let shuffle ((times (cadr message)))
				   (if (= 0 times)
				       (this 'show)
				       (let ((step (select-any-from-list (list 'move-up 'move-down 'move-left 'move-right))))
					    (this step)
					    (shuffle (- times 1))))))
			     ((solved?) 
			      ; checks if the puzzle is solved
			      ; [ FILL IN ]
			      #t)
			     ((solve)
			      ; solve the puzzle starting from a shuffled configuration
			      ; [ FILL IN ]
			      #t)
			     ((error) 
			      ; reports an error message
			      (writeln (cadr message)))
			     (else 
			      ; message to the board object is not recognized
			      (writeln "bad message to board object"))))))
		    this))))

;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;

; board-ref
;  given row and column on a board of size x size, 
;  returns the tile item at that position
; uses the built-in vector-ref function for accessing vector elements
;
(define board-ref
  (lambda (board size row column) 
	  ; [ FILL IN ]
	  #t))

; flat-index
;  given row and column on a board of size x size, 
;  returns the flat vector index of that position
;
(define flat-index
  (lambda (row column size)
    (+ column (*(- row 1)3))))

; get-row 
;  given a flat vector index on the board of size x size, 
;  returns the associated row position
;
(define get-row
  (lambda (flat-index size)
    (cond ((<= flat-index 3)1)
          ((and ( > flat-index 3)(flat-index 6))2)
    (else 3))))


; get-column
;  given a flat vector index on the board of size x size, 
;  returns the associated column position
;
(define get-column
  (lambda (flat-index size)
    (cond((equal? flat-index 1)1)
         ((equal? flat-index 2)2)
         ((equal? flat-index 3)3)
         ((equal? flat-index 4)1)
         ((equal? flat-index 5)2)
         ((equal? flat-index 6)3)
         ((equal? flat-index 7)1)
         ((equal? flat-index 8)2)
         (else 3))))
         

; last-row?
;  given a flat vector index on the board of size x size, 
;  decides if that position is on the last row
;
(define last-row?
  (lambda (flat-index size)
    (cond((equal? (get-row flat-index size)3)
          #t)
         (else #f))))

; last-column?
;  given a flat vector index on the board of size x size, 
;  decides if that position is on the last column
;
(define last-column?
  (lambda (flat-index size)
    (cond((equal? (get-column flat-index size)3)
          #t)
         (else #f))))

; first-row?                          
;  given a flat vector index on the board of size x size, 
;  decides if that position is on the first row
;
(define first-row?
  (lambda (flat-index size)
    (cond((equal? (get-row flat-index size)1)
          #t)
         (else #f))))

; first-column?
;  given a flat vector index on the board of size x size, 
;  decides if that position is on the first column
;
(define first-column?
  (lambda (flat-index size)
    (cond((equal? (get-column flat-index size)1)
          #t)
         (else #f))))

; display-board
;  displays the board of size x size to the text screen
;  as a list of size lists each of length size
;
(define display-board
  (lambda (board size)
	  ; [ FILL IN ]
	  #t))

; sleep
;  wastes a few clock cycles to allow slow human responses to catch up
;
(define sleep
  (lambda (ticks) 
	  (let ((current-time (process-time-clock))) 
	       (let ((end-time (+ current-time ticks))) 
		    (let wait () 
			 (if (> end-time (process-time-clock)) 
			     (wait)))))))

;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;