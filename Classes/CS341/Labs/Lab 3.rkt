; Paul Burgwardt
; CS341 Programming Languages
; Lab 3

(define make-frame
  (lambda (title)
    (make-object frame% title)))

(define make-canvas
  (lambda (frame)
    (make-object canvas% frame)))

(define get-drawing-context
  (lambda (canvas)
    (send canvas get-dc)))

(define clear-screen
  (lambda (dc)
    (send dc clear)))

;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;

(define white (make-object color% "white"))
(define black (make-object color% "black"))
(define red   (make-object color% "red"))
(define blue  (make-object color% "blue"))
(define yellow (make-object color% "yellow"))
(define orange (make-object color% "orange"))

;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;

(define make-window
  (lambda (frame canvas x-size y-size foreground-color background-color)
    (let ((dc (get-drawing-context canvas)))
      (send canvas min-width x-size)
      (send canvas min-height y-size)
      (send canvas stretchable-width #f)
      (send canvas stretchable-height #f)
      (set-background-color dc background-color)
      (set-foreground-color dc foreground-color)
      (send frame show #t)
      (sleep/yield 0.5)
      (clear-screen dc))))

(define set-foreground-color
  (lambda (drawing-context color)
    (send drawing-context set-pen (instantiate pen% (color 1 'solid)))))

(define set-background-color
  (lambda (drawing-context color)
    (send drawing-context set-background (make-object color% color))))

(define draw-point
  (lambda (drawing-context x1 y1 color)
    (send drawing-context set-pen (instantiate pen% (color 1 'solid)))
    (send drawing-context draw-point x1 y1)))

(define select-any-from-list
  (lambda (ls)
    (list-ref ls (random (length ls)))))

(define *colors*
  '("white"
    "red"
    "blue"
    "yellow"
    "orange"))

(define *direction*
  '(1
    2
    3
    4))

(define east
  (lambda (size x1 y1 x2 y2 speed)
    (cond ((equal? x1 size) (moving size x1 y1 x2 y2 speed (select-any-from-list *direction*)))
          ((and(equal? x1 x2) (equal? y1 y2)) '(Finished))
          (else
           (draw-point *my-dc* x1 y1 (select-any-from-list *colors*))
           (sleep/yield speed)
           (moving size (+ x1 1) y1 x2 y2 speed (select-any-from-list *direction*))))))

(define west
  (lambda (size x1 y1 x2 y2 speed)
    (cond ((equal? x1 0) (moving size x1 y1 x2 y2 speed (select-any-from-list *direction*)))
          ((and(equal? x1 x2) (equal? y1 y2)) '(Finished))
          (else
           (draw-point *my-dc* x1 y1 (select-any-from-list *colors*))
           (sleep/yield speed)
           (moving size (- x1 1) y1 x2 y2 speed (select-any-from-list *direction*))))))

(define north
  (lambda (size x1 y1 x2 y2 speed)
    (cond ((equal? y1 0) (moving size x1 y1 x2 y2 speed (select-any-from-list *direction*)))
          ((and(equal? x1 x2) (equal? y1 y2)) '(Finished))
          (else
           (draw-point *my-dc* x1 y1 (select-any-from-list *colors*))
           (sleep/yield speed)
           (moving size x1 (- y1 1) x2 y2 speed (select-any-from-list *direction*))))))

(define south
  (lambda (size x1 y1 x2 y2 speed)
    (cond ((equal? y1 size) (moving size x1 y1 x2 y2 speed (select-any-from-list *direction*)))
          ((and(equal? x1 x2) (equal? y1 y2)) '(Finished))
          (else
           (draw-point *my-dc* x1 y1 (select-any-from-list *colors*))
           (sleep/yield speed)
           (moving size x1 (+ y1 1) x2 y2 speed (select-any-from-list *direction*))))))

(define moving
  (lambda (size x1 y1 x2 y2 speed n)
    (cond ((equal? n 1) (east size x1 y1 x2 y2 speed))
          ((equal? n 2) (west size x1 y1 x2 y2 speed))
          ((equal? n 3) (north size x1 y1 x2 y2 speed))
          ((equal? n 4) (south size x1 y1 x2 y2 speed)))))

;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;

(define *my-frame* (make-frame "My Frame"))
(define *my-canvas* (make-canvas *my-frame*))
(define *my-dc* (get-drawing-context *my-canvas*))

; set up a window
; size is the size of the window
; x1 y1 is the starting point
; x2 y2 is the ending point
; speed is time between placing points
(define test-me
  (lambda (size x1 y1 x2 y2 speed)
    (make-window *my-frame* *my-canvas* size size "blue" "black")
    (moving size x1 y1 x2 y2 speed (select-any-from-list *direction*))))