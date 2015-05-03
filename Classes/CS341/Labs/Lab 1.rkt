#lang racket

; Paul Burgwardt
; CS341 Programming Languages
; Lab 1

; Exercise 1
(define my-sum
  (lambda (n)
    (if (< n 0)
        0
        (+ n (my-sum (- n 1))))))

; Exercise 2
(define my-square-sum
  (lambda (n)
    (if (< n 0)
        0
        (+ (sqr n) (my-square-sum (- n 1))))))

; Exercise 3
(define my-better-sum
  (lambda (f n)
    (if (< n 0)
        0
        (+ (f n) (my-better-sum f (- n 1))))))

; Exercise 4
(define my-generic-sum
  (lambda (f)
    (lambda (n)
      (if (< n 0)
          0
          (+ (f n) ((my-generic-sum f) (- n 1)))))))

; Square Function
(define square
  (lambda (n)
    (* n n)))

; Test Jigs
(define test-me
  (lambda (func n)
    (if (< n 0)
        '()
        (cons (func n) (test-me func (- n 1))))))

(define test-me-again
  (lambda (func foo n)
    (if (< n 0)
        '()
        (cons (func foo n) (test-me-again func foo (- n 1))))))

(define test-me-again2
  (lambda (func foo n)
    (if (< n 0)
        '()
        (cons (func foo n) (test-me-again2 func foo (- n 1))))))